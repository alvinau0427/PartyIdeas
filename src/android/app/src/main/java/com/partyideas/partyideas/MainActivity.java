package com.partyideas.partyideas;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBar;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.amigold.fundapter.BindDictionary;
import com.amigold.fundapter.FunDapter;
import com.amigold.fundapter.extractors.StringExtractor;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.GlideDrawable;
import com.bumptech.glide.request.animation.GlideAnimation;
import com.bumptech.glide.request.target.SimpleTarget;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.GraphRequest;
import com.facebook.GraphResponse;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.google.android.gms.auth.api.Auth;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.Scopes;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Scope;
import com.google.android.gms.common.api.Status;
import com.google.firebase.iid.FirebaseInstanceId;
import com.kosalgeek.android.json.JsonConverter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Locale;

import cat.ereza.customactivityoncrash.CustomActivityOnCrash;

public class MainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    String path = "http://mobile.partyideas.hk/";

    TextView tvName, tvEmail;
    ImageView ivIcon;

    SharedPreferences settings;
    SharedPreferences.Editor edit;

    private NavigationView nav;

    // Google API
    GoogleApiClient mGoogleApiClient;
    final int RC_SIGN_IN = 3434;

    // Facebook API
    private CallbackManager mCallbackManager;

    // Crashing Test
    private static final String TAG = "CrashingTest";

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        settings = getSharedPreferences("account", 0);
        edit = settings.edit();
        loadLocale();
        setContentView(R.layout.activity_main);

        // Enables activity on program crash
        getCrash();

        // Set the fragment initially
        try {
            IndexFragment fragment = new IndexFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } catch (Exception e) {
            getCrash();
        }

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        final ActionBar actionBar = getSupportActionBar();
        actionBar.setHomeAsUpIndicator(R.drawable.ic_menu);
        actionBar.setDisplayHomeAsUpEnabled(true);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        View headerView = navigationView.getHeaderView(0);
        ivIcon = (ImageView) headerView.findViewById(R.id.ivIcon);
        tvName = (TextView) headerView.findViewById(R.id.tvName);
        tvEmail = (TextView) headerView.findViewById(R.id.tvEmail);
        navigationView.setNavigationItemSelectedListener(this);

        checkToken();
        initFacebook();
        setGoogleLogin();

        nav = (NavigationView) findViewById(R.id.nav_view);
        nav.getMenu().findItem(R.id.nav_notification).setVisible(false);

        handleSignInResult();

        showMessageBox();
    }

    private void loadLocale() {
        String language = settings.getString("language", "");
        Locale locale;
        if (language.equalsIgnoreCase("")) {
            locale = new Locale("zh");
        } else {
            locale = new Locale(language);
        }
        Locale.setDefault(locale);
        Configuration config = new Configuration();
        config.locale = locale;
        getBaseContext().getResources().updateConfiguration(config, getBaseContext().getResources().getDisplayMetrics());
    }

    private void getCrash() {
        CustomActivityOnCrash.setLaunchErrorActivityWhenInBackground(true);
        CustomActivityOnCrash.setDefaultErrorActivityDrawable(R.drawable.ic_crash_partyideas);
        CustomActivityOnCrash.setEnableAppRestart(true);
        CustomActivityOnCrash.setEventListener(new CustomEventListener());
        CustomActivityOnCrash.setRestartActivityClass(SplashActivity.class);
        CustomActivityOnCrash.install(this);
        CustomActivityOnCrash.setShowErrorDetails(false);
    }

    private void checkToken() {
        try {
            String query = URLEncoder.encode("SELECT * FROM users WHERE Token = '" + FirebaseInstanceId.getInstance().getToken() + "'", "UTF-8");
            String url = path + "api/Selection.php?statement=" + query;
            StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        JSONArray jArray = new JSONArray(response);// check whether it is JSON format, if not, it is caught and register a new token
                    } catch (Exception e) {
                        try {
                            String url = path + "api/Register.php?Token=" + URLEncoder.encode(FirebaseInstanceId.getInstance().getToken(), "UTF-8");
                            StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                                @Override
                                public void onResponse(String response) {
                                    if (settings.getString("email", "") != "") {
                                        updateToken();
                                    }
                                }
                            }, new Response.ErrorListener() {
                                @Override
                                public void onErrorResponse(VolleyError error) {
                                    Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                                }
                            });

                            MySingleton.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);
                        } catch (Exception ex) {}
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
            });

            MySingleton.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);
        } catch (Exception e) {
            Toast.makeText(this, getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void updateToken() {
        try {
            String account = settings.getString("email", "");
            String token = URLEncoder.encode(FirebaseInstanceId.getInstance().getToken(), "UTF-8");
            String url = path + "api/UpdateToken.php?account=" + account + "&token=" + token;
            StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {}
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
            });

            MySingleton.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);
        } catch (Exception e) {
            Toast.makeText(this, getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void setGoogleLogin() {
        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestScopes(new Scope(Scopes.PLUS_LOGIN))
                .requestEmail()
                .build();

        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .enableAutoManage(this, new GoogleApiClient.OnConnectionFailedListener() {
                    @Override
                    public void onConnectionFailed(ConnectionResult connectionResult) {

                    }
                })
                .addApi(Auth.GOOGLE_SIGN_IN_API, gso)
                .build();
    }

    private void initFacebook() {
        mCallbackManager = CallbackManager.Factory.create();
        LoginManager.getInstance().registerCallback(mCallbackManager,
                new FacebookCallback<LoginResult>() {
                    @Override
                    public void onSuccess(LoginResult loginResult) {
                        Log.d("Success", "Login");
                        GraphRequest request = GraphRequest.newMeRequest(
                                loginResult.getAccessToken(),
                                new GraphRequest.GraphJSONObjectCallback() {
                                    @Override
                                    public void onCompleted(JSONObject user, GraphResponse response) {
                                        try {
                                            edit.putString("uid", user.getString("id"));
                                            edit.putString("name", user.getString("name"));
                                            edit.putString("email", user.getString("email"));
                                            edit.putString("url", "http://graph.facebook.com/" + user.getString("id") + "/picture?type=large");
                                            edit.putString("type", "facebook");
                                            edit.commit();
                                            handleSignInResult();
                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }
                                    }
                                });

                        Bundle parameters = new Bundle();
                        parameters.putString("fields", "id,name,email,gender,birthday");
                        request.setParameters(parameters);
                        request.executeAsync();
                    }

                    @Override
                    public void onCancel() {
                        Toast.makeText(MainActivity.this, getString(R.string.loginMessage_Failed), Toast.LENGTH_LONG).show();
                    }

                    @Override
                    public void onError(FacebookException exception) {
                        Toast.makeText(MainActivity.this, getString(R.string.loginMessage_Failed), Toast.LENGTH_LONG).show();
                    }
                });
    }

    private void loginFacebook() {
        LoginManager.getInstance().logInWithReadPermissions(MainActivity.this, Arrays.asList("public_profile", "email", "user_birthday"));
    }

    private void showMessageBox() {
        final AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setCancelable(false);

        View messageView = LayoutInflater.from(this).inflate(R.layout.message_box, null);
        builder.setView(messageView);

        final AlertDialog alertDialog = builder.create();

        Button btnClose = (Button) messageView.findViewById(R.id.btnClose);
        btnClose.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog.dismiss();
            }
        });

        ListView lvMessage = (ListView) messageView.findViewById(R.id.lvMessage);
        getMessage(lvMessage);

        alertDialog.show();

        DisplayMetrics metrics = new DisplayMetrics();
        getWindowManager().getDefaultDisplay().getMetrics(metrics);
        alertDialog.getWindow().setLayout((int)(metrics.widthPixels * 0.95), (int)(metrics.heightPixels * 0.8));
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if(mCallbackManager.onActivityResult(requestCode, resultCode, data)) {
            return;
        }

        // Result returned from launching the Intent from GoogleSignInApi.getSignInIntent(...);
        if (requestCode == RC_SIGN_IN && resultCode != 0) {
            edit.putString("name", Auth.GoogleSignInApi.getSignInResultFromIntent(data).getSignInAccount().getDisplayName());
            edit.putString("email", Auth.GoogleSignInApi.getSignInResultFromIntent(data).getSignInAccount().getEmail());
            edit.putString("url", String.valueOf(Auth.GoogleSignInApi.getSignInResultFromIntent(data).getSignInAccount().getPhotoUrl()));
            edit.putString("type", "google");
            edit.commit();
            handleSignInResult();
        } else {
            Toast.makeText(MainActivity.this, getString(R.string.loginMessage_Failed), Toast.LENGTH_LONG).show();
        }
    }

    private void handleSignInResult() {
        if ((settings.getString("email", "")).equals("")) {
            tvName.setText(getString(R.string.navigation_name));
            tvEmail.setText(getString(R.string.navigation_email));
            ivIcon.setImageResource(R.mipmap.ic_launcher_partyideas);
            if (nav.getMenu().findItem(R.id.nav_notification).isVisible()) {
                nav.getMenu().findItem(R.id.nav_notification).setVisible(false);
            }
            IndexFragment fragment = new IndexFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else {
            String name = settings.getString("name", "");
            String email = settings.getString("email", "");
            tvName.setText(name);
            tvEmail.setText(email);
            Glide.with(getApplicationContext())
                    .load(settings.getString("url", ""))
                    .placeholder(R.drawable.loading_page)
                    .dontAnimate()
                    .error(R.mipmap.ic_launcher_partyideas)
                    .into(new SimpleTarget<GlideDrawable>() {
                        @Override
                        public void onResourceReady(GlideDrawable resource, GlideAnimation<? super GlideDrawable> glideAnimation) {
                            ivIcon.setImageDrawable(resource.getCurrent());
                        }
                    });
            edit.putString("nickName", (!(settings.getString("nickName", "")).equals("")) ? settings.getString("nickName", "") : name);
            edit.commit();
            updateToken();
            checkAdminAccount();
        }
    }

    private void checkAdminAccount() {
        try {
            String query = URLEncoder.encode("SELECT * FROM admin WHERE LoginAccount = '" + tvEmail.getText().toString() + "'", "UTF-8");
            String url = path + "api/Selection.php?statement=" + query;
            StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        JSONArray jsonArray = new JSONArray(response);
                        if (jsonArray.length() == 1) {
                            nav.getMenu().findItem(R.id.nav_notification).setVisible(true);
                        }
                    }
                    catch (JSONException e) {
                        e.getMessage();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
            });

            MySingleton.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);
        }
        catch (Exception e) {
            Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public void onBackPressed() {
        if (!(getSupportFragmentManager().findFragmentById(R.id.fragment_container) instanceof IndexFragment)) {
            IndexFragment fragment = new IndexFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else {
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setMessage(getString(R.string.exitMessage));
            builder.setCancelable(false);

            builder.setNeutralButton(getString(R.string.loginMessage_no), new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                }
            });

            builder.setPositiveButton(getString(R.string.loginMessage_yes), new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
                    if (drawer.isDrawerOpen(GravityCompat.START)) {
                        drawer.closeDrawer(GravityCompat.START);
                    } else {
                        MainActivity.super.onBackPressed();
                    }
                }
            });
            builder.create();
            builder.show();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        // noinspection SimplifiableIfStatement
        switch (id) {
            case android.R.id.home: {
                onBackPressed();
                return true;
            }
            case R.id.action_profile: {
                Intent intent = new Intent(this, ProfileActivity.class);
                startActivity(intent);
                return true;
            }
            case R.id.action_settings: {
                Intent intent = new Intent(this, SettingActivity.class);
                startActivity(intent);
                return true;
            }
            case R.id.action_notification: {
                showMessageBox();
                return true;
            }
        }
        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_index) {
            IndexFragment fragment = new IndexFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else if (id == R.id.nav_calendar) {
            CalendarFragment fragment = new CalendarFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else if (id == R.id.nav_event) {
            EventFragment fragment = new EventFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else if (id == R.id.nav_booking) {
            PrivateBookingFragment fragment = new PrivateBookingFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else if (id == R.id.nav_boardgame) {
            BoardGameFragment fragment = new BoardGameFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else if (id == R.id.nav_battle) {
            BattleFragment fragment = new BattleFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else if (id == R.id.nav_google) {
            if (settings.getString("email", "") == "") {
                Intent signInIntent = Auth.GoogleSignInApi.getSignInIntent(mGoogleApiClient);
                startActivityForResult(signInIntent, RC_SIGN_IN);
            } else {
                Toast.makeText(this, getString(R.string.loginFailedMessage), Toast.LENGTH_SHORT).show();
            }
        } else if (id == R.id.nav_facebook) {
            if (settings.getString("email", "") == "") {
                loginFacebook();
            } else {
                Toast.makeText(this, getString(R.string.loginFailedMessage), Toast.LENGTH_SHORT).show();
            }
        } else if (id == R.id.nav_notification) {
            MessageFragment fragment = new MessageFragment();
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, fragment);
            fragmentTransaction.commit();
        } else if (id == R.id.nav_logOut) {
            if (!(settings.getString("email", "")).equals("")) {
                AlertDialog.Builder builder = new AlertDialog.Builder(this);
                builder.setMessage(getString(R.string.logoutConfirmMessage));
                builder.setCancelable(false);

                builder.setNeutralButton(getString(R.string.loginMessage_no), new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                    }
                });

                builder.setPositiveButton(getString(R.string.loginMessage_yes), new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        if ((settings.getString("type", "")).equals("facebook")) {
                            LoginManager.getInstance().logOut();
                        } else if ((settings.getString("type", "")).equals("google")) {
                            Auth.GoogleSignInApi.signOut(mGoogleApiClient).setResultCallback(
                                    new ResultCallback<Status>() {
                                        @Override
                                        public void onResult(Status status) {
                                        }
                                    });
                        }
                        edit.putString("uid", "");
                        edit.putString("name", "");
                        edit.putString("email", "");
                        edit.putString("type", "");
                        edit.putString("nickName", "");
                        edit.putString("tel", "");
                        edit.commit();
                        handleSignInResult();
                        Toast.makeText(MainActivity.this, getString(R.string.logoutMessage), Toast.LENGTH_SHORT).show();
                    }
                });
                builder.create();
                builder.show();
            } else {
                Toast.makeText(this, getString(R.string.logoutWarning), Toast.LENGTH_SHORT).show();
            }
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    private void getMessage(final ListView lvMessage) {
        try {
            String query = URLEncoder.encode("SELECT * FROM notification ORDER BY NotificationID DESC LIMIT 10", "UTF-8");
            String url = path + "api/Selection.php?statement=" + query;
            StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        final ArrayList<NotificationDatabase> notificationList = new JsonConverter<NotificationDatabase>().toArrayList(response, NotificationDatabase.class);
                        final BindDictionary<NotificationDatabase> dictionary = new BindDictionary<>();

                        dictionary.addStringField(R.id.tvDateTime, new StringExtractor<NotificationDatabase>() {
                            @Override
                            public String getStringValue(NotificationDatabase notification, int position) {
                                return notification.date.substring(0, 16);
                            }
                        });

                        dictionary.addStringField(R.id.tvTitle, new StringExtractor<NotificationDatabase>() {
                            @Override
                            public String getStringValue(NotificationDatabase notification, int position) {
                                return notification.title;
                            }
                        });

                        dictionary.addStringField(R.id.tvBody, new StringExtractor<NotificationDatabase>() {
                            @Override
                            public String getStringValue(NotificationDatabase notification, int position) {
                                return notification.body;
                            }
                        });

                        FunDapter adapter = new FunDapter<>(
                                getApplicationContext(), notificationList, R.layout.message_box_item, dictionary);

                        lvMessage.setAdapter(adapter);
                    } catch (Exception e) {
                        Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
            });

            MySingleton.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);
        } catch (Exception e) {
            Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    public static class CustomEventListener implements CustomActivityOnCrash.EventListener {
        @Override
        public void onLaunchErrorActivity() {
            Log.i(TAG, "onLaunchErrorActivity()");
        }

        @Override
        public void onRestartAppFromErrorActivity() {
            Log.i(TAG, "onRestartAppFromErrorActivity()");
        }

        @Override
        public void onCloseAppFromErrorActivity() {
            Log.i(TAG, "onCloseAppFromErrorActivity()");
        }
    }

    public String getPath() {
        return path;
    }
}