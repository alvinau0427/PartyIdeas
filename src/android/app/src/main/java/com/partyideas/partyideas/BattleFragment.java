package com.partyideas.partyideas;

import android.app.Activity;
import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.graphics.Paint;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.support.v4.content.ContextCompat;
import android.support.v4.view.ViewCompat;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.SeekBar;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import com.amigold.fundapter.BindDictionary;
import com.amigold.fundapter.FunDapter;
import com.amigold.fundapter.extractors.BooleanExtractor;
import com.amigold.fundapter.extractors.StringExtractor;
import com.amigold.fundapter.interfaces.DynamicImageLoader;
import com.amigold.fundapter.interfaces.ItemClickListener;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.GlideDrawable;
import com.bumptech.glide.request.animation.GlideAnimation;
import com.bumptech.glide.request.target.SimpleTarget;
import com.google.firebase.iid.FirebaseInstanceId;
import com.kosalgeek.android.json.JsonConverter;

import org.json.JSONArray;
import org.json.JSONException;

import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.Locale;
import java.util.TimeZone;

public class BattleFragment extends Fragment implements View.OnClickListener, AdapterView.OnItemSelectedListener, SeekBar.OnSeekBarChangeListener {

    MainActivity m = new MainActivity();
    String path = m.getPath();

    SharedPreferences settings;
    SharedPreferences.Editor edit;

    final String TAG = this.getClass().getSimpleName();
    int tokenID, readyBookEventID;
    final String WEEKDAY_OPEN_TIME = "15:00";
    final String WEEKEND_OPEN_TIME = "14:00";
    final String WEEKDAY_CLOSE_TIME = "23:00";
    final String WEEKEND_CLOSE_TIME = "25:00";
    String[][] arrayOpenTime = { WEEKDAY_OPEN_TIME.split(":"), WEEKEND_OPEN_TIME.split(":") };
    String[][] arrayCloseTime = { WEEKDAY_CLOSE_TIME.split(":"), WEEKEND_CLOSE_TIME.split(":") };
    int fromHour, fromMinutes, toHour, toMinutes;
    String[] thatDayCloseTime;
    String url = null;
    String query = null;
    long today;
    int min, max, remainder;
    SimpleDateFormat date, time;

    ImageView ivReload, ivClose, ivClose2;
    TextView tvCreate, tvDateValue, tvTimeValue, tvTimeWarning, tvNumOfDuration, tvNumOfPeople, tvBook, tvOK, tvCreatePrice, tvPrice;
    EditText etTel, etNum, etSearch;
    Spinner spinner_gameName1, spinner_gameName2, spinner_place;
    SeekBar sbNumPeople, sbDuration;
    View rootView;
    ScrollView scrollDetail;
    LinearLayout noData;
    RelativeLayout relative_num, loadingPanel;
    ListView lvBattle;
    ActionBar actionBar;
    SwipeRefreshLayout mSwipeRefreshLayout;
    Boolean isCorrectFrom = true;

    FunDapter<BattleDatabase> adapter;

    Calendar myCalendar= Calendar.getInstance(TimeZone.getTimeZone("HKT"));

    DatePickerDialog.OnDateSetListener d = new DatePickerDialog.OnDateSetListener() {
        public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
            myCalendar.set(Calendar.YEAR, year);
            myCalendar.set(Calendar.MONTH, monthOfYear);
            myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);

            tvDateValue.setTextColor(Color.GRAY);
            tvDateValue.setPaintFlags(tvDateValue.getPaintFlags() & (~ Paint.UNDERLINE_TEXT_FLAG));
            tvDateValue.setText(year + "-" + (monthOfYear + 1) + "-" + dayOfMonth);

            getPrice(year + "-" + (monthOfYear + 1) + "-" + dayOfMonth);
            // Reset time data only
            resetTimeData();
        }
    };

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        rootView = inflater.inflate(R.layout.fragment_battle_list, container, false);

        settings = getActivity().getSharedPreferences("account", 0);
        edit = settings.edit();

        // ActionBar
        actionBar = ((AppCompatActivity) getActivity()).getSupportActionBar();
        actionBar.setTitle(getString(R.string.navigation_battle));

        // ImageView
        ivReload = (ImageView) rootView.findViewById(R.id.ivReload);
        ivReload.setOnClickListener(this);
        ivClose = (ImageView) rootView.findViewById(R.id.ivClose);
        ViewCompat.setElevation(ivClose, 10);
        ivClose.setOnClickListener(this);
        ivClose2 = (ImageView) rootView.findViewById(R.id.ivClose2);
        ViewCompat.setElevation(ivClose2, 10);
        ivClose2.setOnClickListener(this);

        // TextView
        tvCreate = (TextView) rootView.findViewById(R.id.tvCreate);
        tvDateValue = (TextView) rootView.findViewById(R.id.tvDateValue);
        tvTimeValue = (TextView) rootView.findViewById(R.id.tvTimeValueFrom);
        tvTimeWarning = (TextView) rootView.findViewById(R.id.tvTimeWarning);
        tvTimeWarning.setText(getPIOpenTime());
        tvNumOfDuration = (TextView) rootView.findViewById(R.id.tvNumOfDuration);
        tvNumOfPeople = (TextView) rootView.findViewById(R.id.tvNumOfPeople);
        tvBook  = (TextView) rootView.findViewById(R.id.tvBook);
        tvOK  = (TextView) rootView.findViewById(R.id.tvOK);
        tvCreatePrice = (TextView) rootView.findViewById(R.id.tvCreatePrice);
        tvPrice = (TextView) rootView.findViewById(R.id.tvPrice);

        tvCreate.setOnClickListener(this);
        tvDateValue.setOnClickListener(this);
        tvTimeValue.setOnClickListener(this);
        tvBook.setOnClickListener(this);
        tvOK.setOnClickListener(this);

        // EditText
        etTel = (EditText) rootView.findViewById(R.id.etTel);
        etNum = (EditText) rootView.findViewById(R.id.etNum);
        etSearch = (EditText) rootView.findViewById(R.id.etSearch);

        // ListView
        lvBattle = (ListView) rootView.findViewById(R.id.lvBattle);

        // Spinner
        spinner_gameName1 = (Spinner) rootView.findViewById(R.id.spinner);
        spinner_gameName2 = (Spinner) rootView.findViewById(R.id.spinnerGameName);
        spinner_place = (Spinner) rootView.findViewById(R.id.spinner_place);

        spinner_gameName1.setOnItemSelectedListener(this);
        spinner_gameName2.setOnItemSelectedListener(this);
        spinner_place.setOnItemSelectedListener(this);

        // SeekBar
        sbNumPeople = (SeekBar) rootView.findViewById(R.id.sbNumPeople);
        sbNumPeople.setOnSeekBarChangeListener(this);
        sbDuration = (SeekBar) rootView.findViewById(R.id.sbDuration);
        sbDuration.setOnSeekBarChangeListener(this);

        // Scroll View
        scrollDetail = (ScrollView) rootView.findViewById(R.id.scroll_detail);
		
		// Loading View
        noData = (LinearLayout) rootView.findViewById(R.id.noData);
        relative_num = (RelativeLayout) rootView.findViewById(R.id.relative_num);
        loadingPanel = (RelativeLayout) rootView.findViewById(R.id.loadingPanel);
        loadingPanel.setVisibility(View.INVISIBLE);

        mSwipeRefreshLayout = (SwipeRefreshLayout) rootView.findViewById(R.id.srl_refresh);
        // mSwipeRefreshLayout.setProgressViewOffset(true, 50, 200); // Refresh Circle Scaling, Start Location, End Location
        mSwipeRefreshLayout.setSize(SwipeRefreshLayout.DEFAULT); // Refresh Circle Size
        mSwipeRefreshLayout.setColorSchemeResources(android.R.color.holo_purple);
        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                new Handler().postDelayed(new Runnable() {
                    public void run() {
                        try {
                            query = URLEncoder.encode("SELECT * FROM boardgame WHERE status = 0 or status = 1", "UTF-8");
                            runStatement(path + "api/Selection.php?statement=" + query, "game");
                            showToast(getActivity(), getString(R.string.view_message_success), 1000);
                            mSwipeRefreshLayout.setRefreshing(false);
                        } catch (Exception e) {
                            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                        }
                    }
                }, 800);
            }
        });

        try{
            query = URLEncoder.encode("SELECT * FROM boardgame WHERE status = 0 or status = 1 ORDER BY BoardGameName", "UTF-8");
            runStatement(path + "api/Selection.php?statement=" + query, "game");

            query = URLEncoder.encode("SELECT * FROM location", "UTF-8");
            runStatement(path + "api/Selection.php?statement=" + query, "location");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }

        today = System.currentTimeMillis();
        date = new SimpleDateFormat("yyyy-MM-dd");
        time = new SimpleDateFormat("HH:mm:ss");
        getToken();

        etSearch.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                try {
                    query = URLEncoder.encode("SELECT * , location.Place AS location, gatheringbattle.Status AS BattleStatus FROM gatheringbattle, boardgame, location" +
                            " where gatheringbattle.BoardGameID = boardgame.BoardGameID" +
                            " and boardgame.BoardGameName LIKE '%" + etSearch.getText().toString() + "%'" +
                            " and gatheringbattle.Place = location.LocationID" +
                            " and (gatheringbattle.Date > '" + date.format(today).toString() +
                            "' or (gatheringbattle.Date = '" + date.format(today).toString() +
                            "' and gatheringbattle.Time > '" + time.format(today).toString() +
                            "')) and gatheringbattle.Status != 2" +
                            " and gatheringbattle.Status != 3" +
                            " and gatheringbattle.Status != 4 ORDER BY gatheringbattle.Date, gatheringbattle.Time", "UTF-8");
                    runStatement(path + "api/Selection.php?statement=" + query, "battle");
                } catch (Exception e) {
                    Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        return rootView;
    }

    private void runStatement(String url, final String type) {
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d(TAG, response);
                loadData(response, type);
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        });

        MySingleton.getInstance(getActivity()).addToRequestQueue(stringRequest);
    }

    private void loadData(final String response, String type) {
        try {
            if (type.equals("game")  || type.equals("form")) {
                JSONArray jArray = new JSONArray(response);
                String[] items;
                if (type.equals("game")) {
                    items = new String[jArray.length() + 1];
                    items[0] = getString(R.string.battleActivity_all);
                    for (int i = 0; i < jArray.length(); i++) {
                        if (jArray.getJSONObject(i).getString("BoardGameName").indexOf("\n") != -1)
                            items[i + 1] = jArray.getJSONObject(i).getString("BoardGameName").substring(0, jArray.getJSONObject(i).getString("BoardGameName").indexOf("\n"));
                        else
                            items[i + 1] = jArray.getJSONObject(i).getString("BoardGameName");
                    }
                } else {
                    items = new String[jArray.length()];
                    for (int i = 0; i < jArray.length(); i++) {
                        if (jArray.getJSONObject(i).getString("BoardGameName").indexOf("\n") != -1)
                            items[i] = jArray.getJSONObject(i).getString("BoardGameName").substring(0, jArray.getJSONObject(i).getString("BoardGameName").indexOf("\n"));
                        else
                            items[i] = jArray.getJSONObject(i).getString("BoardGameName");
                    }
                }

                ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, items);

                if (type.equals("game")) {
                    spinner_gameName1.setAdapter(adapter);
                } else {
                    spinner_gameName2.setAdapter(adapter);
                }
            } else if (type.equals("battle")) {
                final ArrayList<BattleDatabase> battleList = new JsonConverter<BattleDatabase>().toArrayList(response, BattleDatabase.class);
                final BindDictionary<BattleDatabase> dictionary = new BindDictionary<>();

                dictionary.addStringField(R.id.tvBattleGameName, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        return getString(R.string.battleActivity_name) + " " + (position + 1) + " - " + battle.boardGameName;
                    }
                });

                dictionary.addDynamicImageField(R.id.ivPhoto, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        return battle.photo;
                    }
                }, new DynamicImageLoader() {
                    @Override
                    public void loadImage(String url, final ImageView view) {
                        if (url != null) {
                            Glide.with(getContext())
                                    .load(path + "BoardGameImage/" + url)
                                    .placeholder(R.drawable.loading_page)
                                    .dontAnimate()
                                    .fitCenter()
                                    .into(new SimpleTarget<GlideDrawable>() {
                                        @Override
                                        public void onResourceReady(GlideDrawable resource, GlideAnimation<? super GlideDrawable> glideAnimation) {
                                            view.setImageDrawable(resource.getCurrent());
                                        }
                                    });
                        }
                    }
                });

                dictionary.addStringField(R.id.tvHost, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        return getString(R.string.battleActivity_roomHoster) + " " + ((battle.memberName.length() > 15)? battle.memberName.substring(0, 15) + "..." : battle.memberName);
                    }
                });

                dictionary.addStringField(R.id.tvDate, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        return getString(R.string.battleActivity_date) + " " + battle.date;
                    }
                });

                dictionary.addStringField(R.id.tvTime, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        return getString(R.string.battleActivity_time) + " " + battle.time.substring(0, 5);
                    }
                });

                dictionary.addStringField(R.id.tvPlace, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        return getString(R.string.battleActivity_place) + " " + battle.location;
                    }
                });

                dictionary.addStringField(R.id.tvRequirement, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        return getString(R.string.battleActivity_requirement) + " " + getNumOfJoinedParticipant(battle.joinedParticipant) + " / " + battle.requirement;
                    }
                });

                dictionary.addStringField(R.id.tvParticipantValue, new StringExtractor<BattleDatabase>() {
                    @Override
                    public String getStringValue(BattleDatabase battle, int position) {
                        String name = "";
                        if (!battle.joinedParticipant.equals("")) {
                            try {
                                JSONArray jArray = new JSONArray(battle.joinedParticipant);
                                for(int i = 0; i < jArray.length(); i++) {
                                    String nickName = URLDecoder.decode(jArray.getJSONObject(i).getString("nickName"), "UTF-8");
                                    name += nickName.length() > 10 ? nickName.substring(0, 10) + "..." : nickName;
                                    if (jArray.getJSONObject(i).getString("extraPeople").compareTo("") != 0) {
                                        name += "+" + jArray.getJSONObject(i).getString("extraPeople") + "\n";
                                    } else {
                                        name += "\n";
                                    }
                                }
                            } catch (Exception e) {
                                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                            }
                        }
                        return name;
                    }
                });

                dictionary.addConditionalVisibilityField(R.id.rvBook, new BooleanExtractor<BattleDatabase>() {
                    @Override
                    public boolean getBooleanValue(BattleDatabase battle, int position) {
                        return (battle.status == -1);
                    }
                }, View.INVISIBLE).onClick(new ItemClickListener<BattleDatabase>() {
                    @Override
                    public void onClick(BattleDatabase battle, int position, View view) {
                        if (!(settings.getString("email", "")).equals("")) {
                            readyBookEventID = battle.eventID;
                            remainder = battle.requirement - getNumOfJoinedParticipant(battle.joinedParticipant);
                            getPrice(battle.date);
                            relative_num.setVisibility(View.VISIBLE);
                        } else {
                            Toast.makeText(getActivity(), getString(R.string.logoutWarning), Toast.LENGTH_SHORT).show();
                        }
                    }
                });

                dictionary.addConditionalVisibilityField(R.id.rvFull, new BooleanExtractor<BattleDatabase>() {
                    @Override
                    public boolean getBooleanValue(BattleDatabase battle, int position) {
                        return (battle.status == 0);
                    }
                }, View.INVISIBLE);

                dictionary.addConditionalVisibilityField(R.id.rvConfirmed, new BooleanExtractor<BattleDatabase>() {
                    @Override
                    public boolean getBooleanValue(BattleDatabase battle, int position) {
                        return (battle.status == 1);
                    }
                }, View.INVISIBLE);

                dictionary.addConditionalVisibilityField(R.id.rvCancelled, new BooleanExtractor<BattleDatabase>() {
                    @Override
                    public boolean getBooleanValue(BattleDatabase battle, int position) {
                        if (!(settings.getString("email", "")).equals("")) {
                            String account = settings.getString("email", "");
                            if (battle.account.compareTo(account) == 0) {
                                return true;
                            } else if (!battle.joinedParticipant.equals("")) {
                                try {
                                    JSONArray jArray = new JSONArray(battle.joinedParticipantToken);
                                    for(int i = 0; i < jArray.length(); i++) {
                                        if (URLDecoder.decode(jArray.getJSONObject(i).getString("token"), "UTF-8").contains(account)) {
                                            return true;
                                        }
                                    }
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                } catch (UnsupportedEncodingException e) {
                                    Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                                }
                            }
                        }
                        return false;
                    }
                }, View.INVISIBLE).onClick(new ItemClickListener<BattleDatabase>() {
                    @Override
                    public void onClick(final BattleDatabase battle, int position, View view) {
                        if (!(settings.getString("email", "")).equals("")){
                            String account = settings.getString("email", "");
                            if (battle.account.compareTo(account) == 0) {
                                AlertDialog.Builder a = new AlertDialog.Builder(getContext());
                                a.setTitle(getString(R.string.battleActivity_warnning));
                                a.setMessage(getString(R.string.battleActivity_warnningMessage));
                                a.setCancelable(false);

                                a.setPositiveButton(getString(R.string.messageActivity_yes), new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialogInterface, int i) {
                                        removeBattle(battle.eventID);
                                    }
                                });

                                a.setNegativeButton(getString(R.string.messageActivity_no), new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialogInterface, int i) {

                                    }
                                });

                                a.create();
                                a.show();
                            } else {
                                cancelBattle(battle.eventID);
                            }
                        } else {
                            Toast.makeText(getActivity(), getString(R.string.logoutWarning), Toast.LENGTH_SHORT).show();
                        }
                    }
                });

                adapter = new FunDapter<>(getActivity(), battleList, R.layout.fragment_battle_item, dictionary);

                adapter.setAlternatingBackground(R.color.battle_backColor_odd, R.color.battle_backColor_even);
                lvBattle.setAdapter(adapter);
                if (lvBattle.getAdapter().getCount() > 0)
                    noData.setVisibility(View.INVISIBLE);
                else
                    noData.setVisibility(View.VISIBLE);
            } else if (type.equals("requirement")) {
                JSONArray jArray = new JSONArray(response);
                min = jArray.getJSONObject(0).getInt("Player_Minimum");
                max = jArray.getJSONObject(0).getInt("Player_Maximum");
                sbNumPeople.setMax(max);

            } else if (type.equals("location")) {
                JSONArray jArray = new JSONArray(response);
                String[] items = new String[jArray.length()];
                for (int i = 0; i < jArray.length(); i++) {
                    items[i] = jArray.getJSONObject(i).getString("Place");
                }
                ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, items);
                adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                spinner_place.setAdapter(adapter);
            } else if (type.equals("price")) {
                JSONArray jArray = new JSONArray(response);
                tvPrice.setText(getString(R.string.battleActivity_Price) + " " + jArray.getJSONObject(0).getString("Price"));
                tvCreatePrice.setText(getString(R.string.battleActivity_Price) + " " + jArray.getJSONObject(0).getString("Price") + "\n" + getString(R.string.battleActivity_Time));
            } else if (type.equals("token")) {
                JSONArray jArray = new JSONArray(response);
                tokenID = jArray.getJSONObject(0).getInt("ID");
            } else if (type.equals("insert")) {
                if (response.contains("true")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_openSuccessfully), Toast.LENGTH_SHORT).show();
                    scrollDetail.setVisibility(View.INVISIBLE);
                } else if (response.contains("thatdaycreated")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_openFailed), Toast.LENGTH_SHORT).show();
                } else if (response.contains("has2room")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_openFailed2Room), Toast.LENGTH_SHORT).show();
                }
            } else if (type.equals("update")) {
                if (response.contains("true")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_successful), Toast.LENGTH_SHORT).show();
                } else if (response.contains("hoster")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_hoster), Toast.LENGTH_SHORT).show();
                } else if (response.contains("blacklisted")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_blacklisted), Toast.LENGTH_SHORT).show();
                } else if (response.contains("joined")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_failed), Toast.LENGTH_SHORT).show();
                }
            } else if (type.equals("cancel")) {
                if (response.contains("true")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_cancellSuccessfully), Toast.LENGTH_SHORT).show();
                } else if (response.contains("cancelled")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_cancellFailed), Toast.LENGTH_SHORT).show();
                }
            } else if (type.equals("remove")) {
                if (response.contains("true")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_cancellSuccessfully), Toast.LENGTH_SHORT).show();
                } else if (response.contains("false")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_cancellFailed), Toast.LENGTH_SHORT).show();
                }
            }
        }
        catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.battleActivity_noBattle_message), Toast.LENGTH_SHORT).show();
        }
    }

    private int getNumOfJoinedParticipant(String joinedParticipant) {
        if (!joinedParticipant.equals("")) {
            int num = 0;
            try {
                JSONArray jArray = new JSONArray(joinedParticipant);
                for(int i = 0; i < jArray.length(); i++) {
                    if (jArray.getJSONObject(i).getString("extraPeople").compareTo("") != 0) {
                        num += Integer.parseInt(jArray.getJSONObject(i).getString("extraPeople")) + 1;
                    } else {
                        num += 1;
                    }
                }
            } catch (Exception e) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
            return num;
        } else {
            return 1;
        }
    }

    private void joinBattle(int eventID, int extraPeople) {
        try {
            String account = settings.getString("email", "");
            String sExtraPeople = (extraPeople != 0) ? extraPeople + "" : "";
            String nickName = URLEncoder.encode(settings.getString("nickName", settings.getString("name", "")), "UTF-8");
            String user = URLEncoder.encode(account, "UTF-8");
            url = path + "api/JoinBattle.php?token=" + tokenID + "&nickName=" + nickName + "&extraPeople=" + sExtraPeople + "&user=" + user + "&eventID=" + eventID;
            runStatement(url, "update");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void cancelBattle(int eventID) {
        try {
            String account = settings.getString("email", "");
            String user = URLEncoder.encode(account, "UTF-8");
            url = path + "api/CancelBattle.php?user=" + user + "&eventID=" + eventID;
            runStatement(url, "cancel");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void removeBattle(int eventID) {
        try {
            url = path + "api/RemoveBattle.php?eventID=" + eventID;
            runStatement(url, "remove");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvCreate:
                isCorrectFrom = true; // reset timeWrongNumber
                resetData();
                scrollDetail.setVisibility(View.VISIBLE);
                break;
            case R.id.tvDateValue:
                new DatePickerDialog(getActivity(), R.style.DialogTheme, d,
                        myCalendar.get(Calendar.YEAR),
                        myCalendar.get(Calendar.MONTH),
                        myCalendar.get(Calendar.DAY_OF_MONTH)).show();
                break;
            case R.id.tvTimeValueFrom:
                if (!tvDateValue.getText().toString().contains(getString(R.string.battleActivity_dateSelect))) {
                    new TimePickerDialog(getActivity(), R.style.DialogTheme, new TimePickerDialog.OnTimeSetListener() {
                        @Override
                        public void onTimeSet(TimePicker view, int hourOfDay, int minute) {
                            loadTimeData(view, hourOfDay, (minute / 30) * 30, tvTimeValue);
                        }
                    }, myCalendar.get(Calendar.HOUR_OF_DAY), myCalendar.get(Calendar.MINUTE), true).show();
                } else {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_dateSelectFailed), Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.tvBook:
                if ( (!(settings.getString("nickName", "")).equals("")) && (!(settings.getString("email", "")).equals("")) ) {
                     if (checkData()) {
                        insertData();
                     }
                } else {
                    Toast.makeText(getActivity(), getString(R.string.logoutWarning), Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.ivReload:
                try {
					loadingPanel.setVisibility(View.VISIBLE);
                    query = URLEncoder.encode("SELECT * FROM boardgame WHERE status = 0 or status = 1 ORDER BY BoardGameName", "UTF-8");
                    runStatement(path + "api/Selection.php?statement=" + query, "game");
                    showToast(getActivity(), getString(R.string.view_message_success), 1000);
                    loadingPanel.setVisibility(View.GONE);
                } catch (Exception e) {
                    Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
                break;
            case R.id.ivClose:
                resetData();
                scrollDetail.setVisibility(View.INVISIBLE);
                break;
            case R.id.tvOK:
                if (etNum.getText().toString().length() == 0 ||  (etNum.getText().toString()).equals("0")) {
                    Toast.makeText(getActivity(), getString(R.string.battleActivity_confirmMessage), Toast.LENGTH_SHORT).show();
                } else {
                    int extraPeople = Integer.parseInt(etNum.getText().toString()) - 1;
                    if (extraPeople + 1 > remainder)
                        Toast.makeText(getActivity(), getString(R.string.battleActivity_moreThanRemainderMessage), Toast.LENGTH_SHORT).show();
                    else {
                        joinBattle(readyBookEventID, extraPeople);
                        etNum.setText("");
                        relative_num.setVisibility(View.INVISIBLE);
                    }
                }
                break;
            case R.id.ivClose2:
                etNum.setText("");
                relative_num.setVisibility(View.INVISIBLE);
                break;
        }
    }

    private void getPrice(String s) {
        String[] date = s.split("-");
        int year = Integer.parseInt(date[0]);
        int month = Integer.parseInt(date[1]);
        int day = Integer.parseInt(date[2]);
        SimpleDateFormat sdf = new SimpleDateFormat("EEEE", Locale.ENGLISH);
        myCalendar.set(year, month - 1, day);
        try {
            query = URLEncoder.encode("SELECT " + sdf.format(myCalendar.getTime()) + " AS Price FROM gatheringbattleprice WHERE PriceID = 1", "UTF-8");
            runStatement(path + "api/Selection.php?statement=" + query, "price");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void loadTimeData(TimePicker view, int hourOfDay, int minute, TextView textView) {
        myCalendar.set(Calendar.HOUR_OF_DAY, hourOfDay);
        myCalendar.set(Calendar.MINUTE, minute);

        String timeText = get12Hour(hourOfDay) + " : " + String.format("%02d", minute) + getAMPM(hourOfDay);

        isCorrectFrom = checkTime(hourOfDay, minute, textView, (myCalendar.get(Calendar.DAY_OF_WEEK) == Calendar.SATURDAY || myCalendar.get(Calendar.DAY_OF_WEEK) == Calendar.SUNDAY) ? arrayOpenTime[1] : arrayOpenTime[0], (myCalendar.get(Calendar.DAY_OF_WEEK) == Calendar.SATURDAY || myCalendar.get(Calendar.DAY_OF_WEEK) == Calendar.SUNDAY) ? arrayCloseTime[1] : arrayCloseTime[0]);
        textView.setPaintFlags(textView.getPaintFlags() & (~ Paint.UNDERLINE_TEXT_FLAG));
        textView.setText(timeText);
    }

    private String getPIOpenTime() {
        return getString(R.string.battleActivity_openTime) + "\n" +
                getString(R.string.battleActivity_weekday) + " " + get12Hour(Integer.parseInt(arrayOpenTime[0][0])) + " : " + String.format("%02d", Integer.parseInt(arrayOpenTime[0][1])) + getAMPM(Integer.parseInt(arrayOpenTime[0][0])) + " - " + get12Hour(Integer.parseInt(arrayCloseTime[0][0])) + " : " + String.format("%02d", Integer.parseInt(arrayCloseTime[0][1])) + getAMPM(Integer.parseInt(arrayCloseTime[0][0])) + "\n" +
                getString(R.string.battleActivity_weekend) + " " + get12Hour(Integer.parseInt(arrayOpenTime[1][0])) + " : " + String.format("%02d", Integer.parseInt(arrayOpenTime[1][1])) + getAMPM(Integer.parseInt(arrayOpenTime[1][0])) + " - " + get12Hour(Integer.parseInt(arrayCloseTime[1][0])) + " : " + String.format("%02d", Integer.parseInt(arrayCloseTime[1][1])) + getAMPM(Integer.parseInt(arrayCloseTime[1][0]));
    }

    private boolean checkTime(int hourOfDay, int minute, TextView textView, String[] openTime, String[] closeTime) {
        thatDayCloseTime = closeTime;// keep close time record
        if ((hourOfDay < Integer.parseInt(openTime[0]) || (hourOfDay == Integer.parseInt(openTime[0]) && minute < Integer.parseInt(openTime[1]))) || hourOfDay >= Integer.parseInt(closeTime[0])) {
            textView.setTextColor(getResources().getColor(R.color.error_text));
            return false;
        } else {
            textView.setTextColor(Color.GRAY);
            if (textView == tvTimeValue) {
                fromHour = toHour = hourOfDay;
                fromMinutes = toMinutes = minute;
            }
            return true;
        }
    }

    private int get12Hour(int hourOfDay) {
        return (hourOfDay > 12)? hourOfDay % 12 : hourOfDay;
    }

    private String getAMPM(int hourOfDay) {
        return (hourOfDay >= 12 && hourOfDay < 24)? " p.m" : " a.m";
    }

    private void resetData() {
        try {
            query = URLEncoder.encode("SELECT * FROM boardgame WHERE status = 0 or status = 1", "UTF-8");
            runStatement(path + "api/Selection.php?statement=" + query, "form");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
        tvDateValue.setText(getString(R.string.battleActivity_dateSelect));
        tvDateValue.setTextColor(getResources().getColor(R.color.dialog_pink));
        tvDateValue.setPaintFlags(tvDateValue.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
        resetTimeData();
        tvNumOfDuration.setText("0");
        sbDuration.setProgress(0);
        tvNumOfPeople.setText("0");
        sbNumPeople.setProgress(0);
        if (settings.getString("tel", null) != null) {
            etTel.setText(settings.getString("tel", null));
        }
        tvCreatePrice.setText("");
        tvPrice.setText("");
    }


    private void resetTimeData() {
        tvTimeValue.setText(getString(R.string.battleActivity_timeSelect));
        tvTimeValue.setTextColor(getResources().getColor(R.color.dialog_pink));
        tvTimeValue.setPaintFlags(tvTimeValue.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
    }

    private boolean checkData() {
        if (tvDateValue.getText() == getString(R.string.battleActivity_dateSelect)) {
            Toast.makeText(getActivity(), getString(R.string.battleActivity_dateSelectFailed), Toast.LENGTH_SHORT).show();
            return false;
        } else if (myCalendar.getTime().compareTo(new Date(today + 1)) <= 0) {
            Toast.makeText(getActivity(), getString(R.string.battleActivity_BookDate), Toast.LENGTH_SHORT).show();
            return false;
        }
        if (tvTimeValue.getText() == getString(R.string.battleActivity_timeSelect)) {
            Toast.makeText(getActivity(), getString(R.string.battleActivity_timeSelectFailed), Toast.LENGTH_SHORT).show();
            return false;
        }
        if (sbDuration.getProgress() == 0) {
            Toast.makeText(getActivity(), getString(R.string.battleActivity_durationSelectFailed), Toast.LENGTH_SHORT).show();
            return false;
        } else if (sbDuration.getProgress() >= 1 && ((fromHour + sbDuration.getProgress()) < Integer.parseInt(thatDayCloseTime[0]) || (fromHour + sbDuration.getProgress()) == Integer.parseInt(thatDayCloseTime[0]) && toMinutes <= Integer.parseInt(thatDayCloseTime[1]))) {
            tvNumOfDuration.setTextColor(getResources().getColor(R.color.spinner));
        } else {
            tvNumOfDuration.setTextColor(getResources().getColor(R.color.error_text));
            Toast.makeText(getActivity(), getString(R.string.battleActivity_overOpeningHours), Toast.LENGTH_SHORT).show();
            return false;
        }
        if (sbNumPeople.getProgress() >= min) {
            tvNumOfPeople.setTextColor(getResources().getColor(R.color.spinner));
        } else {
            tvNumOfPeople.setTextColor(getResources().getColor(R.color.error_text));
            Toast.makeText(getActivity(), getString(R.string.battleActivity_lessThanGameLimit), Toast.LENGTH_SHORT).show();
            return false;
        }
        if (etTel.getText().toString().length() == 8) {
            etTel.setTextColor(getResources().getColor(R.color.spinner));
        } else {
            etTel.setTextColor(getResources().getColor(R.color.error_text));
            Toast.makeText(getActivity(), getString(R.string.battleActivity_telError), Toast.LENGTH_SHORT).show();
            return false;
        }
        return (tvDateValue.getText() != getString(R.string.battleActivity_dateSelect) &&
				myCalendar.getTime().compareTo(new Date(today + 1)) > 0 &&
                (!tvTimeValue.getText().toString().contains(getString(R.string.battleActivity_timeSelect)) && tvTimeValue.getCurrentTextColor() != ContextCompat.getColor(getContext(), R.color.error_text)) &&
                sbDuration.getProgress() >= 1 &&
                ((fromHour + sbDuration.getProgress()) < Integer.parseInt(thatDayCloseTime[0]) || (fromHour + sbDuration.getProgress()) == Integer.parseInt(thatDayCloseTime[0]) && toMinutes <= Integer.parseInt(thatDayCloseTime[1])) &&
                sbNumPeople.getProgress() >= min &&
                etTel.getText().toString().length() == 8);
    }

    private void insertData() {
        try {
            int gameID = spinner_gameName2.getSelectedItemPosition() + 1;
            String account = URLEncoder.encode(settings.getString("email", ""), "UTF-8");
            String nickName = URLEncoder.encode(settings.getString("nickName", ""), "UTF-8");
            String date = tvDateValue.getText().toString();
            String startTime = URLEncoder.encode(fromHour + ":" + fromMinutes, "UTF-8");
            String endTime = URLEncoder.encode(toHour + ":" + toMinutes, "UTF-8");
            int location = spinner_place.getSelectedItemPosition() + 1;
            int num = sbNumPeople.getProgress();
            String tel = etTel.getText().toString();
            url = path + "api/CreateBoardGame.php?gameID=" + gameID +
                    "&nickName=" + nickName +
                    "&account=" + account +
                    "&tel=" + tel +
                    "&date=" + date +
                    "&startTime=" + startTime +
                    "&endTime=" + endTime +
                    "&location=" + location +
                    "&num=" + num;
            runStatement(url, "insert");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void getToken() {
        try {
            query = URLEncoder.encode("SELECT * FROM users WHERE Token = '" + FirebaseInstanceId.getInstance().getToken() + "'", "UTF-8");
            runStatement(path + "api/Selection.php?statement=" + query, "token");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int position, long l) {
        switch (adapterView.getId()) {
            case R.id.spinner:
                try {
                    query = URLEncoder.encode("SELECT * , location.Place AS location, gatheringbattle.Status AS BattleStatus FROM gatheringbattle, boardgame, location" +
                            " where gatheringbattle.BoardGameID = boardgame.BoardGameID" +
                            " and (boardgame.BoardGameName = '" + adapterView.getItemAtPosition(position).toString() + "'" +
                            " or " + (position == 0) + ")" +
                            " and gatheringbattle.Place = location.LocationID" +
                            " and (gatheringbattle.Date > '" + date.format(today).toString() +
                            "' or (gatheringbattle.Date = '" + date.format(today).toString() +
                            "' and gatheringbattle.Time > '" + time.format(today).toString() +
                            "')) and gatheringbattle.Status != 2" +
                            " and gatheringbattle.Status != 3" +
                            " and gatheringbattle.Status != 4 ORDER BY gatheringbattle.Date, gatheringbattle.Time", "UTF-8");
                    runStatement(path + "api/Selection.php?statement=" + query, "battle");
                } catch (Exception e) {
                    Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
                break;
            case R.id.spinnerGameName:
                try{
                    query = URLEncoder.encode("SELECT BoardGameID, Player_Minimum, Player_Maximum FROM boardgame" +
                            " WHERE BoardGameID = " + (position + 1), "UTF-8");
                    runStatement(path + "api/Selection.php?statement=" + query, "requirement");
                } catch (Exception e) {
                    Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                }
                break;
            case R.id.spinner_place:
                break;
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {}

    @Override
    public void onProgressChanged(SeekBar seekBar, int progress, boolean fromUser) {
        switch (seekBar.getId()) {
            case R.id.sbDuration:
                toHour = fromHour + seekBar.getProgress();
                tvNumOfDuration.setText(progress + "");
                break;
            case R.id.sbNumPeople:
                tvNumOfPeople.setText(progress + "");
                break;
        }
    }

    @Override
    public void onStartTrackingTouch(SeekBar seekBar) {}

    @Override
    public void onStopTrackingTouch(SeekBar seekBar) {}

    public void showToast(final Activity activity, final String word, final long time) {
        activity.runOnUiThread(new Runnable() {
            public void run() {
                final Toast toast = Toast.makeText(activity, word, Toast.LENGTH_LONG);
                toast.show();
                Handler handler = new Handler();
                handler.postDelayed(new Runnable() {
                    public void run() {
                        toast.cancel();
                    }
                }, time);
            }
        });
    }
}