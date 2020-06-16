package com.partyideas.partyideas;

import android.app.DatePickerDialog;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.graphics.Paint;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.ImageView;
import android.widget.SeekBar;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.GlideDrawable;
import com.bumptech.glide.request.animation.GlideAnimation;
import com.bumptech.glide.request.target.SimpleTarget;
import com.emmasuzuki.easyform.EasyTextInputLayout;
import com.google.firebase.iid.FirebaseInstanceId;

import org.json.JSONArray;

import java.net.URLEncoder;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.TimeZone;

public class PrivateBookingFragment extends Fragment implements AdapterView.OnItemSelectedListener, SeekBar.OnSeekBarChangeListener, View.OnClickListener {

    MainActivity m = new MainActivity();
    String path = m.getPath();

    final String WEEKDAY_OPEN_TIME = "15:00";
    final String WEEKEND_OPEN_TIME = "14:00";
    final String WEEKDAY_CLOSE_TIME = "23:00";
    final String WEEKEND_CLOSE_TIME = "25:00";
    String[][] arrayOpenTime = { WEEKDAY_OPEN_TIME.split(":"), WEEKEND_OPEN_TIME.split(":") };
    String[][] arrayCloseTime = { WEEKDAY_CLOSE_TIME.split(":"), WEEKEND_CLOSE_TIME.split(":") };

    public SharedPreferences settings;
    public SharedPreferences.Editor edit;

    View rootView;
    ActionBar actionBar;
    int tokenID;
    EasyTextInputLayout name, num, tel, remark;
    TextView tvNumOfDuration, tvDateValue, tvTimeWarning;
    SeekBar sbDuration;
    Spinner spinner_place, spTimeUnit, spHour, spMinutes;
    Button btnSubmit;
    ImageView ivPhoto;
    String url, query, unit, hour, conhour, minutes;
    int basicPeople, basicHour;
    double basicPrice, extraFoodPrice, extraHourPrice, extraPeoplePrice;
    final double DISCOUNT = 0;

    Calendar myCalendar= Calendar.getInstance(TimeZone.getTimeZone("HKT"));

    DatePickerDialog.OnDateSetListener d = new DatePickerDialog.OnDateSetListener() {
        public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
            myCalendar.set(Calendar.YEAR, year);
            myCalendar.set(Calendar.MONTH, monthOfYear);
            myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);

            tvDateValue.setTextColor(Color.GRAY);
            tvDateValue.setPaintFlags(tvDateValue.getPaintFlags() & (~ Paint.UNDERLINE_TEXT_FLAG));
            tvDateValue.setText(year + "-" + (monthOfYear + 1) + "-" + dayOfMonth);
        }
    };

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        rootView = inflater.inflate(R.layout.fragment_privatebooking, container, false);

        settings = getActivity().getSharedPreferences("account", 0);
        edit = settings.edit();

        // ActionBar
        actionBar = ((AppCompatActivity) getActivity()).getSupportActionBar();
        actionBar.setTitle(getString(R.string.navigation_booking));

        // EasyTextInputLayout
        name = (EasyTextInputLayout) rootView.findViewById(R.id.name);
        num = (EasyTextInputLayout) rootView.findViewById(R.id.people);
        tel = (EasyTextInputLayout) rootView.findViewById(R.id.tel);
        remark = (EasyTextInputLayout) rootView.findViewById(R.id.remark);

        // TextView
        tvNumOfDuration = (TextView) rootView.findViewById(R.id.tvNumOfDuration);
        tvNumOfDuration.setText("0");
        tvDateValue = (TextView) rootView.findViewById(R.id.tvDateValue);
        tvDateValue.setOnClickListener(this);
        tvDateValue.setText(getString(R.string.battleActivity_dateSelect));
        tvDateValue.setTextColor(getResources().getColor(R.color.dialog_pink));
        tvDateValue.setPaintFlags(tvDateValue.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
        tvTimeWarning = (TextView) rootView.findViewById(R.id.tvTimeWarning);
        tvTimeWarning.setText(getPIOpenTime());

        // SeekBar
        sbDuration = (SeekBar) rootView.findViewById(R.id.sbDuration);
        sbDuration.setOnSeekBarChangeListener(this);

        // Spinner
        spTimeUnit = (Spinner) rootView.findViewById(R.id.spTimeUnit);
        spTimeUnit.setOnItemSelectedListener(this);
        spHour = (Spinner) rootView.findViewById(R.id.spHour);
        spHour.setOnItemSelectedListener(this);
        spMinutes = (Spinner) rootView.findViewById(R.id.spMinutes);
        spMinutes.setOnItemSelectedListener(this);
        spinner_place = (Spinner) rootView.findViewById(R.id.spinner_place);
        spinner_place.setOnItemSelectedListener(this);

        // Button
        btnSubmit = (Button) rootView.findViewById(R.id.btnSubmit);
        btnSubmit.setOnClickListener(this);
        ivPhoto = (ImageView) rootView.findViewById(R.id.ivPhoto);

        setTimeSpinnerData();
        getPrice();
        getLocation();
        getPhoto();

        if (!(settings.getString("email", "")).equals("")) {
            name.getEditText().setText(settings.getString("nickName", settings.getString("name", "")));
            if (!(settings.getString("tel", "")).equals("")) {
                tel.getEditText().setText(settings.getString("tel", ""));
            }
        }
        getToken();
        return rootView;
    }

    private String getPIOpenTime() {
        return getString(R.string.battleActivity_openTime) + "\n" +
                getString(R.string.battleActivity_weekday) + " " + get12Hour(Integer.parseInt(arrayOpenTime[0][0])) + " : " + String.format("%02d", Integer.parseInt(arrayOpenTime[0][1])) + getAMPM(Integer.parseInt(arrayOpenTime[0][0])) + " - " + get12Hour(Integer.parseInt(arrayCloseTime[0][0])) + " : " + String.format("%02d", Integer.parseInt(arrayCloseTime[0][1])) + getAMPM(Integer.parseInt(arrayCloseTime[0][0])) + "\n" +
                getString(R.string.battleActivity_weekend) + " " + get12Hour(Integer.parseInt(arrayOpenTime[1][0])) + " : " + String.format("%02d", Integer.parseInt(arrayOpenTime[1][1])) + getAMPM(Integer.parseInt(arrayOpenTime[1][0])) + " - " + get12Hour(Integer.parseInt(arrayCloseTime[1][0])) + " : " + String.format("%02d", Integer.parseInt(arrayCloseTime[1][1])) + getAMPM(Integer.parseInt(arrayCloseTime[1][0]));
    }

    private int get12Hour(int hourOfDay) {
        return (hourOfDay > 12)? hourOfDay % 12 : hourOfDay;
    }

    private String getAMPM(int hourOfDay) {
        return (hourOfDay >= 12 && hourOfDay < 24)? " p.m" : " a.m";
    }

    private void setTimeSpinnerData() {
        ArrayAdapter<String> adapter;
        String[] items;

        items = getResources().getStringArray(R.array.time);
        adapter = new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, items);
        spTimeUnit.setAdapter(adapter);

        items = new String[]{"", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"};
        adapter = new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, items);
        spHour.setAdapter(adapter);

        items = new String[]{"", "00", "30"};
        adapter = new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, items);
        spMinutes.setAdapter(adapter);
    }

    private void getPrice() {
        try{
            query = URLEncoder.encode("SELECT * FROM privatebookingprice WHERE PriceID = 1", "UTF-8");
            url = path + "api/Selection.php?statement=" + query;
            runStatement(url, "price");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void getPhoto() {
        try{
            query = URLEncoder.encode("SELECT * FROM photo WHERE Status = 2", "UTF-8");
            url = path + "api/Selection.php?statement=" + query;
            runStatement(url, "photo");
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
        }
    }

    private void getLocation() {
        try{
            query = URLEncoder.encode("SELECT * FROM location", "UTF-8");
            url = path + "api/Selection.php?statement=" + query;
            runStatement(url, "location");
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
    public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
        switch (adapterView.getId()) {
            case R.id.spTimeUnit:
                unit = adapterView.getSelectedItem().toString();
                break;
            case R.id.spHour:
                hour = adapterView.getSelectedItem().toString();
                break;
            case R.id.spMinutes:
                minutes = adapterView.getSelectedItem().toString();
                break;
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {}

    @Override
    public void onProgressChanged(SeekBar seekBar, int progress, boolean fromUser) {
        tvNumOfDuration.setText(progress + (""));
    }

    @Override
    public void onStartTrackingTouch(SeekBar seekBar) {}

    @Override
    public void onStopTrackingTouch(SeekBar seekBar) {}

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvDateValue:
                new DatePickerDialog(getActivity(), R.style.DialogTheme, d,
                        myCalendar.get(Calendar.YEAR),
                        myCalendar.get(Calendar.MONTH),
                        myCalendar.get(Calendar.DAY_OF_MONTH)).show();
                break;
            case R.id.btnSubmit:
                if (settings.getString("email", "") != "") {
                    if (sbDuration.getProgress() != 0) {
                        String y = myCalendar.get(Calendar.YEAR) + "";
                        String m = myCalendar.get(Calendar.MONTH) + "";
                        String d = myCalendar.get(Calendar.DAY_OF_MONTH) + "";
                        if (!tvDateValue.getText().toString().contains(getString(R.string.battleActivity_dateSelect))) {
                            try {
                                String nickName = URLEncoder.encode(name.getEditText().getText().toString(), "UTF-8");
                                String account = URLEncoder.encode(settings.getString("email", ""), "UTF-8");
                                String date = y + "-" + m + "-" + d;
                                if (spHour.getSelectedItemPosition() == 0 || spMinutes.getSelectedItemPosition() == 0 || tvNumOfDuration.getText().toString().compareTo("0") == 0) {
                                    Toast.makeText(getActivity(), getString(R.string.error_message_timeValid), Toast.LENGTH_SHORT).show();
                                    break;
                                }
                                if (spTimeUnit.getSelectedItemPosition() == 0) {
                                    conhour = (Integer.parseInt(hour) + 12) + "";
                                } else {
                                    conhour = hour;
                                }
                                String startTime = URLEncoder.encode(conhour + ":" + minutes, "UTF-8");
                                int duration = Integer.parseInt(tvNumOfDuration.getText().toString());
                                String endTime = URLEncoder.encode((Integer.parseInt(conhour) + duration) % 24 + ":" + minutes, "UTF-8");
                                int place = spinner_place.getSelectedItemPosition() + 1;
                                int numOfPeople = Integer.parseInt(num.getEditText().getText().toString());
                                String phone = tel.getEditText().getText().toString();
                                String encodedRemark = URLEncoder.encode(remark.getEditText().getText().toString(), "UTF-8");

                                double totalTimePrice = (duration > basicHour) ? (duration - basicHour) * extraHourPrice : 0;
                                double totalPeoplePrice = (numOfPeople > basicPeople) ? (numOfPeople - basicPeople) * (extraPeoplePrice + extraFoodPrice) : 0;
                                double totalPrice = basicPrice + totalTimePrice + totalPeoplePrice;

                                url = path + "api/AddPrivateBooking.php?name=" + nickName +
                                        "&account=" + account +
                                        "&tel=" + phone +
                                        "&date=" + date +
                                        "&startTime=" + startTime +
                                        "&endTime=" + endTime +
                                        "&place=" + place +
                                        "&num=" + numOfPeople +
                                        "&totalPrice=" + totalPrice +
                                        "&discount=" + DISCOUNT +
                                        "&remark=" + encodedRemark;
                                runStatement(url, "insert");
                            } catch (Exception e) {
                                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                            }
                        } else {
                            Toast.makeText(getActivity(), getString(R.string.error_message_dateValid), Toast.LENGTH_SHORT).show();
                        }
                    } else {
                        Toast.makeText(getActivity(), getString(R.string.error_message_durationSubmit), Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(getActivity(), getString(R.string.logoutWarning), Toast.LENGTH_SHORT).show();
                }
                break;
        }
    }

    private void runStatement(String url, final String type) {
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
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

    private void loadData(String response, String type) {
        try {
            if (type.equals("location")) {
                JSONArray jArray = new JSONArray(response);
                String[] items = new String[jArray.length()];
                for (int i = 0; i < jArray.length(); i++) {
                    items[i] = jArray.getJSONObject(i).getString("Place");
                }
                ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, items);
                adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                spinner_place.setAdapter(adapter);
            } else if (type.equals("token")) {
                JSONArray jArray = new JSONArray(response);
                tokenID = jArray.getJSONObject(0).getInt("ID");
            } else if (type.equals("insert")) {
                if (response.contains("true")) {
                    Toast.makeText(getActivity(), getString(R.string.privateBookingActivity_successful), Toast.LENGTH_SHORT).show();
                    reloadFragment();
                }
            } else if (type.equals("photo")) {
                JSONArray jArray = new JSONArray(response);
                String item = jArray.getJSONObject(0).getString("PhotoName");
                Glide.with(getActivity())
                        .load(path + "Photo/" + item)
                        .placeholder(R.drawable.loading_page)
                        .dontAnimate()
                        .error(R.drawable.logo)
                        .fitCenter()
                        .into(new SimpleTarget<GlideDrawable>() {
                            @Override
                            public void onResourceReady(GlideDrawable resource, GlideAnimation<? super GlideDrawable> glideAnimation) {
                                ivPhoto.setImageDrawable(resource.getCurrent());
                            }
                        });
            } else if (type.equals("price")) {
                JSONArray jArray = new JSONArray(response);
                basicPrice = jArray.getJSONObject(0).getDouble("BasicPrice");
                basicPeople = jArray.getJSONObject(0).getInt("BasicPeople");
                basicHour = jArray.getJSONObject(0).getInt("BasicHour");
                extraFoodPrice = jArray.getJSONObject(0).getDouble("ExtraFoodPricePerPeople");
                extraHourPrice = jArray.getJSONObject(0).getDouble("ExtraPricePerHour");
                extraPeoplePrice = jArray.getJSONObject(0).getDouble("ExtraPricePerPeople");
            }
        } catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_SHORT).show();
        }
    }

    private void reloadFragment() {
        getActivity().getSupportFragmentManager().beginTransaction()
                .replace(R.id.fragment_container, new PrivateBookingFragment())
                .commit();
    }
}
