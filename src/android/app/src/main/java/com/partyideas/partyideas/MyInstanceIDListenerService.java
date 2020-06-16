package com.partyideas.partyideas;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

import okhttp3.OkHttpClient;
import okhttp3.Request;

public class MyInstanceIDListenerService extends FirebaseInstanceIdService {

    MainActivity m = new MainActivity();
    String path = m.getPath();

    @Override
    public void onTokenRefresh() {

        String token = FirebaseInstanceId.getInstance().getToken();

        registerToken(token);
    }

    private void registerToken(String token) {

        OkHttpClient client = new OkHttpClient();

        Request request = null;
        try {
            request = new Request.Builder()
                    .url(path + "api/Register.php?Token=" + URLEncoder.encode(token, "UTF-8"))
                    .build();

            client.newCall(request).execute();
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
};
