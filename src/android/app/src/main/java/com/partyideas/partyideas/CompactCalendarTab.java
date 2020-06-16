package com.partyideas.partyideas;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.github.sundeepk.compactcalendarview.CompactCalendarView;
import com.github.sundeepk.compactcalendarview.domain.Event;

import org.json.JSONArray;
import org.json.JSONException;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.List;
import java.util.Locale;
import java.util.TimeZone;

public class CompactCalendarTab extends Fragment implements Response.Listener<String> {

    private static final String TAG = "MainActivity";
    private SimpleDateFormat timeFormat = new SimpleDateFormat("HH:ss");
    private SimpleDateFormat dateFormatForMonth = new SimpleDateFormat("MMM-yyyy", Locale.getDefault());
    private Calendar currentCalender = Calendar.getInstance(TimeZone.getTimeZone("HKT")); // for calendar table (all events)
    private Calendar c = new GregorianCalendar(TimeZone.getTimeZone("HKT")); // for one event calendar
    private Calendar cto = new GregorianCalendar(TimeZone.getTimeZone("HKT")); // for one event calendar
    private CompactCalendarView compactCalendarView;
    private TextView textView;

    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View v =inflater.inflate(R.layout.main_tab,container,false);

        final List<String> mutableBookings = new ArrayList<>();

        final ListView bookingsListView = (ListView) v.findViewById(R.id.bookings_listview);

        final ArrayAdapter adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_list_item_1, mutableBookings);
        bookingsListView.setAdapter(adapter);
        compactCalendarView = (CompactCalendarView) v.findViewById(R.id.compactcalendar_view);

        // below allows you to configure color for the current day in the month
        compactCalendarView.setCurrentDayBackgroundColor(getResources().getColor(R.color.calender_current_date));
        // below allows you to configure colors for the current day the user has selected
        compactCalendarView.setCurrentSelectedDayBackgroundColor(getResources().getColor(R.color.calender_user_select));

        compactCalendarView.setLocale(Locale.CHINESE);
        compactCalendarView.setUseThreeLetterAbbreviation(true);

        showEventData();
        compactCalendarView.invalidate();

        logEventsByMonth(compactCalendarView);

        textView.setText(dateFormatForMonth.format(new Date()));
        compactCalendarView.setCurrentDate(new Date());

        //set title on calendar scroll
        compactCalendarView.setListener(new CompactCalendarView.CompactCalendarViewListener() {
            @Override
            public void onDayClick(Date dateClicked) {
                List<Event> bookingsFromMap = compactCalendarView.getEvents(dateClicked);
                Log.d(TAG, "inside onclick " + dateClicked);
                if(bookingsFromMap != null){
                    Log.d(TAG, bookingsFromMap.toString());
                    mutableBookings.clear();
                    for(Event booking : bookingsFromMap){
                        mutableBookings.add((String)booking.getData());
                    }
                    adapter.notifyDataSetChanged();
                }
            }

            @Override
            public void onMonthScroll(Date firstDayOfNewMonth) {
                textView.setText(dateFormatForMonth.format(firstDayOfNewMonth));
            }
        });
//
//        showCalendarWithAnimationBut.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                if (shouldShow) {
//                    compactCalendarView.showCalendarWithAnimation();
//                } else {
//                    compactCalendarView.hideCalendarWithAnimation();
//                }
//                shouldShow = !shouldShow;
//            }
//        });

//        setLocaleBut.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                compactCalendarView.setLocale(Locale.ENGLISH);
//                compactCalendarView.setUseThreeLetterAbbreviation(true);
//                loadEvents(compactCalendarView);
//            }
//        });

//        removeAllEventsBut.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                compactCalendarView.removeAllEvents();
//            }
//        });
        return v;
    }

    private void showEventData() {
        String url = "https://api.meetup.com/partyideas/events";

        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, this, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        });

        MySingleton.getInstance(getActivity()).addToRequestQueue(stringRequest);
    }

    private void logEventsByMonth(CompactCalendarView compactCalendarView) {
        Log.d(TAG, "Events for current month: " + compactCalendarView.getEventsForMonth(currentCalender.getTime()));
        currentCalender.setTime(new Date());
        currentCalender.set(Calendar.DAY_OF_MONTH, 1);
        currentCalender.set(Calendar.MONTH, Calendar.JANUARY);
        Log.d(TAG, "Events for Jan month: " + compactCalendarView.getEventsForMonth(currentCalender.getTime()));
    }

    private void addEvents(CompactCalendarView compactCalendarView, String message) {
        currentCalender.setTime(new Date());
        currentCalender.set(Calendar.DAY_OF_MONTH, 1);
        Date firstDayOfMonth = currentCalender.getTime();
        currentCalender.setTime(firstDayOfMonth);
        if (c.get(Calendar.MONTH) > -1) {
            currentCalender.set(Calendar.MONTH, c.get(Calendar.MONTH));
        }
        currentCalender.add(Calendar.DATE, c.get(Calendar.DAY_OF_MONTH) - 1);
        setToMidnight(currentCalender, 1, 2);
        long timeInMillis = currentCalender.getTimeInMillis();

        List<Event> events = getEvents(timeInMillis, timeFormat.format(c.getTime()), timeFormat.format(cto.getTime()), message);

        compactCalendarView.addEvents(events);
    }

    private List<Event> getEvents(long timeInMillis, String time, String toTime, String message) {
        return Arrays.asList(new Event(R.color.calender_event_node, timeInMillis, message + "\n" + getString(R.string.eventActivity_time) + " " + time + " - " + toTime));
    }

    private void setToMidnight(Calendar calendar, int hour, int minute) {
        calendar.set(Calendar.HOUR_OF_DAY, hour);
        calendar.set(Calendar.MINUTE, minute);
    }

    @Override
    public void onResponse(String response) {
        loadData(response);
    }

    private void loadData(String response) {
        Log.d("---------------------", response);
        try {
            JSONArray jsonArray = new JSONArray(response);
            for (int i = 0; i < jsonArray.length(); i++) {
                String title = jsonArray.getJSONObject(i).getString("name");
                c.setTimeInMillis(jsonArray.getJSONObject(i).getLong("time"));
                cto.setTimeInMillis(jsonArray.getJSONObject(i).getLong("time") + jsonArray.getJSONObject(i).getLong("duration"));
                addEvents(compactCalendarView, title);
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    public void setShowView(TextView textView) {
        this.textView = textView;
    }
}