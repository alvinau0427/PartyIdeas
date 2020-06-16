package com.partyideas.partyideas;

import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.CardView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.CompoundButton;
import android.widget.Spinner;
import android.widget.Switch;
import android.widget.Toast;

import com.afollestad.materialdialogs.DialogAction;
import com.afollestad.materialdialogs.MaterialDialog;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.github.javiersantos.materialstyleddialogs.MaterialStyledDialog;
import com.google.firebase.iid.FirebaseInstanceId;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.Locale;

public class SettingActivity extends AppCompatActivity implements CompoundButton.OnCheckedChangeListener, AdapterView.OnItemSelectedListener {

    MainActivity m = new MainActivity();
    String path = m.getPath();

    public SharedPreferences settings;
    public SharedPreferences.Editor edit;
    Switch switch_notification;
    String url;
//    Spinner spinner;
    String[] key;
    String[] items;
    CardView cvLanguage, cvRating, cvNotification;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        settings = getSharedPreferences("account", 0);
        edit = settings.edit();
        setContentView(R.layout.activity_settings);

//        cvLanguage = (CardView) findViewById(R.id.cv_language);
        cvRating = (CardView) findViewById(R.id.cv_rating);
        cvNotification = (CardView) findViewById(R.id.cv_notification);

        cvRating.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getGoogleRating();
            }
        });

        key = getResources().getStringArray(R.array.languageKey);
        items = getResources().getStringArray(R.array.languageItem);
//        spinner = (Spinner) findViewById(R.id.spinner);
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, R.layout.spinner_item, items);
//        spinner.setAdapter(adapter);

//        spinner.setOnItemSelectedListener(this);

        switch_notification = (Switch) findViewById(R.id.switch_notification);
        switch_notification.setOnCheckedChangeListener(this);

        switch_notification.setChecked(settings.getBoolean("receiveNotification", true));

        final Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }

    @Override
    public void onCheckedChanged(CompoundButton compoundButton, boolean isCheck) {
        try {
            String token = URLEncoder.encode(FirebaseInstanceId.getInstance().getToken(), "UTF-8");
            if (isCheck) {
                url = path + "api/UpdateTokenReceiveMessage.php?token=" + token + "&updateStatus=0";
            } else {
                url = path + "api/UpdateTokenReceiveMessage.php?token=" + token + "&updateStatus=1";
            }
            runStatement(url, isCheck);
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
    }

    private void runStatement(String url, final Boolean isCheck) {
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                if (response.contains("true")) {
                    edit.putBoolean("receiveNotification", isCheck);
                    edit.commit();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getApplication(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        });

        MySingleton.getInstance(getApplication()).addToRequestQueue(stringRequest);
    }

    @Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int position, long id) {
        if(position != 0) {
            Locale locale = new Locale(key[position]);
            saveLocale(key[position]);
            Locale.setDefault(locale);
            Configuration config = new Configuration();
            config.locale = locale;
            getBaseContext().getResources().updateConfiguration(config, getBaseContext().getResources().getDisplayMetrics());
            this.finish();
            Intent intent = new Intent(this, MainActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            intent.setFlags(Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {}

    private void saveLocale(String lang) {
        edit.putString("language", lang);
        edit.commit();
    }

    public void getGoogleRating() {
        new MaterialStyledDialog(this)
                .setTitle(getString(R.string.settingActivity_rating_dialog_title))
                .setDescription(getString(R.string.settingActivity_rating_dialog_description))
                .setIcon(R.drawable.ic_google_play)
                .withDialogAnimation(true)
                .setHeaderDrawable(R.drawable.bg_navigation)
                .setHeaderColor(R.color.colorPrimaryDark)
                .setPositive(getString(R.string.settingActivity_rating_dialog_intent), new MaterialDialog.SingleButtonCallback() {
                    @Override
                    public void onClick(MaterialDialog dialog, DialogAction which) {
                        startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("https://www.facebook.com/partyideas.hk/")));
                    }
                })
                .setNegative(getString(R.string.settingActivity_rating_dialog_back), new MaterialDialog.SingleButtonCallback() {
                    @Override
                    public void onClick(MaterialDialog dialog, DialogAction which) {
                        dialog.dismiss();
                    }
                })
                .show();
    }
}