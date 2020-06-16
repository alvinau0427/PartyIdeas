package com.partyideas.partyideas;

import android.app.Activity;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.app.Fragment;
import android.support.v4.view.ViewCompat;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.text.Html;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.amigold.fundapter.BindDictionary;
import com.amigold.fundapter.FunDapter;
import com.amigold.fundapter.extractors.StringExtractor;
import com.amigold.fundapter.interfaces.ItemClickListener;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.kosalgeek.android.json.JsonConverter;

import java.util.ArrayList;

public class EventFragment extends Fragment implements Response.Listener<String> {

    final String TAG = this.getClass().getSimpleName();
    String url = null;

    View rootView;
    ListView lvEvent;
    RelativeLayout relativeDetail;
    WebView wvDetail;
    TextView tvBook;
    ImageView ivClose;
    FloatingActionButton btnTop;
    ActionBar actionBar;
    SwipeRefreshLayout mSwipeRefreshLayout;

    EventDatabase eventData;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        rootView = inflater.inflate(R.layout.fragment_event_list, container, false);
        lvEvent = (ListView) rootView.findViewById(R.id.lvEvent);
        relativeDetail = (RelativeLayout) rootView.findViewById(R.id.relative_detail);
        wvDetail = (WebView) rootView.findViewById(R.id.wvDetail);
        tvBook = (TextView) rootView.findViewById(R.id.tvBook);
        ivClose = (ImageView) rootView.findViewById(R.id.ivClose);
        btnTop = (FloatingActionButton) rootView.findViewById(R.id.btnTop);
        actionBar = ((AppCompatActivity) getActivity()).getSupportActionBar();
        mSwipeRefreshLayout = (SwipeRefreshLayout) rootView.findViewById(R.id.srl_refresh);

        actionBar.setTitle(getString(R.string.navigation_event));

        tvBook.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(eventData.link));
                startActivity(intent);
            }
        });

        ViewCompat.setElevation(ivClose, 10);
        ivClose.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                btnTop.setVisibility(View.VISIBLE);
                relativeDetail.setVisibility(View.INVISIBLE);
            }
        });

        btnTop.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                lvEvent.smoothScrollToPosition(0);
            }
        });

        // mSwipeRefreshLayout.setProgressViewOffset(true, 50, 200); // Refresh Circle Scaling, Start Location, End Location
        mSwipeRefreshLayout.setSize(SwipeRefreshLayout.DEFAULT); // Refresh Circle Size
        mSwipeRefreshLayout.setColorSchemeResources(android.R.color.holo_purple);
        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                new Handler().postDelayed(new Runnable() {
                    public void run() {
                        try {
                            showEventData();
                            // Toast.makeText(getActivity(), getString(R.string.view_message_success), Toast.LENGTH_LONG).show();
                            showToast(getActivity(), getString(R.string.view_message_success), 1000);
                            mSwipeRefreshLayout.setRefreshing(false);
                        } catch (Exception e) {
                            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                        }
                    }
                }, 800);
            }
        });

        showEventData();
        return rootView;
    }

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

    public void showEventData() {
        url = "https://api.meetup.com/partyideas/events";

        StringRequest stringRequest = new StringRequest(Request.Method.GET, url, this, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        });

        MySingleton.getInstance(getActivity()).addToRequestQueue(stringRequest);
    }

    @Override
    public void onResponse(String response) {
        Log.d(TAG, response);
        loadData(response, -1);

    }

    public void loadData(final String response, final int target) {
        try {
            ArrayList<EventDatabase> eventList = new JsonConverter<EventDatabase>().toArrayList(response, EventDatabase.class);
            final BindDictionary<EventDatabase> dictionary = new BindDictionary<>();

            dictionary.addStringField(R.id.tvEventName, new StringExtractor<EventDatabase>() {
                @Override
                public String getStringValue(EventDatabase event, int position) {
                    return event.eventName;
                }
            });

            dictionary.addStringField(R.id.tvDetail, new StringExtractor<EventDatabase>() {
                @Override
                public String getStringValue(EventDatabase event, int position) {
                    String description = event.description;
                    try{
                        while (description.indexOf("http://photo") != -1) {
                            description = description.replace(description.substring(description.indexOf("<p><img"), description.indexOf("\" /></p>") + 8), " ");
                        }
                        description = description.substring(0, description.indexOf("/p>") + 3);

                    } catch (Exception e) {
                        description = event.description.substring(0, event.description.indexOf("/p>") + 3);
                    }
                    return String.valueOf(Html.fromHtml(description));
                }
            });

            dictionary.addBaseField(R.id.tvMore).onClick(new ItemClickListener<EventDatabase>() {
                @Override
                public void onClick(EventDatabase event, int position, View view) {
                    btnTop.setVisibility(View.INVISIBLE);
                    eventData = event;
                    loadData(response, position);
                    wvDetail.loadDataWithBaseURL(null, "<html><body><style>strong{font-size: 25px;color: purple;font-weight: bold;}img{display: inline;height: auto;max-width: 100%;}</style><strong>" + event.eventName + "</strong><br /><br />" + event.description + "</body></html>", "text/html", "UTF-8", null);
                    relativeDetail.setVisibility(View.VISIBLE);
                }
            });

            FunDapter<EventDatabase> adapter = new FunDapter<>(
                    getActivity(), eventList, R.layout.fragment_event_item, dictionary);

            adapter.setAlternatingBackground(R.color.battle_backColor_odd, R.color.battle_backColor_even);
            lvEvent.setAdapter(adapter);
            if (target == -1) {
                lvEvent.setSelection(0);
            } else {
                lvEvent.setSelection(target);
            }
        } catch (Exception e) {
            // Clear listView
            lvEvent.setAdapter(null);
            Toast.makeText(getActivity(), e.getMessage(), Toast.LENGTH_SHORT).show();
        }
    }
}