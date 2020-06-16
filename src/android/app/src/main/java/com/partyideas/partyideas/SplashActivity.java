package com.partyideas.partyideas;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.util.Log;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import cat.ereza.customactivityoncrash.CustomActivityOnCrash;

public class SplashActivity extends Activity {

    TextView tvVersion, tvLogo;
    ImageView ivLogo;
    Animation animLoad, animEnd;

    // Crashing Test
    private static final String TAG = "CrashingTest";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);

        tvVersion = (TextView) findViewById(R.id.tvVersion);
        tvVersion.setTypeface(Typeface.createFromAsset(getAssets(), "fonts/Pacifico.ttf"));
        tvLogo = (TextView) findViewById(R.id.tvLogo);
        tvLogo.setTypeface(Typeface.createFromAsset(getAssets(), "fonts/Pacifico.ttf"));
        ivLogo = (ImageView) findViewById(R.id.ivLogo);
        animLoad = AnimationUtils.loadAnimation(getBaseContext(), R.anim.logo_animation);
        animEnd = AnimationUtils.loadAnimation(getBaseContext(), R.anim.fade_out);

        ivLogo.startAnimation(animLoad);
        animLoad.setAnimationListener(new Animation.AnimationListener() {
            @Override
            public void onAnimationStart(Animation animation) {
                if (isConnected()) {
                    Log.d("NetworkConnection", "Network Connected.");
                }else {
                    Log.d("NetworkConnection", "No network connection available.");
                    // Enables activity on program crash
                    CustomActivityOnCrash.setLaunchErrorActivityWhenInBackground(true);
                    CustomActivityOnCrash.setShowErrorDetails(true);
                    CustomActivityOnCrash.setDefaultErrorActivityDrawable(R.drawable.ic_crash_partyideas);
                    CustomActivityOnCrash.setEnableAppRestart(true);
                    CustomActivityOnCrash.setEventListener(new CustomEventListener());
                    CustomActivityOnCrash.setRestartActivityClass(SplashActivity.class);
                    CustomActivityOnCrash.install(getApplicationContext());
                    Toast.makeText(getApplicationContext(), getString(R.string.connect_failed_message), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onAnimationEnd(Animation animation) {
                ivLogo.startAnimation(animEnd);
                finish();
                Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                startActivity(intent);
            }

            @Override
            public void onAnimationRepeat(Animation animation) {

            }
        });

    }

    private boolean isConnected() {
        ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = cm.getActiveNetworkInfo();
        if (networkInfo != null && networkInfo.isConnected()) {
            return true;
        }
        return false;
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
}
