package com.partyideas.partyideas;

import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.TextInputLayout;
import android.support.v4.app.Fragment;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.util.HashMap;

public class MessageFragment extends Fragment implements Response.Listener<String>, View.OnClickListener {

    MainActivity m = new MainActivity();
    String path = m.getPath();

    SharedPreferences settings;
    SharedPreferences.Editor edit;

    final String TAG = this.getClass().getSimpleName();
    String url;
    String title = "";
    String message = "";
    TextInputLayout titleLayout, nameLayout;
    EditText etTitle, etMessage;
    FloatingActionButton fabConfirm;
    View rootView;
    ActionBar actionBar;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        rootView = inflater.inflate(R.layout.fragment_message, container, false);

        settings = getActivity().getSharedPreferences("account", 0);
        edit = settings.edit();

        fabConfirm = (FloatingActionButton) rootView.findViewById(R.id.fabConfirm);
        titleLayout = (TextInputLayout) rootView.findViewById(R.id.layout_msg_title);
        etTitle = (EditText) rootView.findViewById(R.id.etTitle);
        nameLayout = (TextInputLayout) rootView.findViewById(R.id.layout_msg_message);
        etMessage = (EditText) rootView.findViewById(R.id.etMessage);
        actionBar = ((AppCompatActivity) getActivity()).getSupportActionBar();

        actionBar.setTitle(getString(R.string.actionbar_notification_setting_title));

        fabConfirm.setOnClickListener(this);

        titleLayout.setErrorEnabled(true);
        nameLayout.setErrorEnabled(true);

        return rootView;
    }

    @Override
    public void onResponse(String response) {
        Log.d(TAG, response);
        if (!response.isEmpty()){
            Toast.makeText(getActivity(), getString(R.string.messageActivity_success), Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public void onClick(View view) {
        if (etTitle.length() == 0) {
            titleLayout.setError(getString(R.string.messageActivity_msg_error));
        } else {
            titleLayout.setError(null);
        }

        if (etTitle.length() == 0) {
            nameLayout.setError(getString(R.string.messageActivity_msg_error));
        } else {
            nameLayout.setError(null);
        }

        try {
            title = URLEncoder.encode(etTitle.getText().toString(), "UTF-8");
            message = URLEncoder.encode(etMessage.getText().toString(), "UTF-8");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }

        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        try {
            builder.setTitle(getString(R.string.messageActivity_title) + getString(R.string.messageActivity_titleName) + URLDecoder.decode(title, "UTF-8"));
            builder.setMessage(getString(R.string.messageActivity_message) + URLDecoder.decode(message, "UTF-8") + getString(R.string.messageActivity_confirmMsg));
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
        builder.setCancelable(false);

        builder.setNeutralButton((R.string.messageActivity_no),  new DialogInterface.OnClickListener()   {
            @Override
            public void onClick(DialogInterface dialog, int which)    {
            }
        });

        builder.setPositiveButton((R.string.messageActivity_yes),  new DialogInterface.OnClickListener()   {
            @Override
            public void onClick(DialogInterface dialog, int which)    {
                sendNotification();
                addNotification();
            }
        });

        builder.create();
        builder.show();
    }

    public void sendNotification() {
        url = path + "api/Receive.php";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, this, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected HashMap<String, String> getParams()
                    throws AuthFailureError {
                HashMap<String, String> hashMap = new HashMap<String, String>();
                hashMap.put("title", title);
                hashMap.put("body", message);
                return hashMap;
            }
        };

        MySingleton.getInstance(getActivity()).addToRequestQueue(stringRequest);
    }

    private void addNotification() {
        url = path + "api/addNotification.php";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, this, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected HashMap<String, String> getParams()
                    throws AuthFailureError {
                HashMap<String, String> hashMap = new HashMap<String, String>();
                hashMap.put("title", title);
                hashMap.put("body", message);
                if (settings.getString("uid", "") != "") {
                    hashMap.put("uid", settings.getString("uid", settings.getString("name", "")));
                } else {
                    hashMap.put("uid", settings.getString("nickName", settings.getString("name", "")));
                }
                hashMap.put("name", settings.getString("nickName", settings.getString("name", "")));
                return hashMap;
            }
        };

        MySingleton.getInstance(getActivity()).addToRequestQueue(stringRequest);
    }
}