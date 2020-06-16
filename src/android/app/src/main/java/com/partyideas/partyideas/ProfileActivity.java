package com.partyideas.partyideas;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v4.view.ViewCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.text.InputFilter;
import android.text.InputType;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.GlideDrawable;
import com.bumptech.glide.request.animation.GlideAnimation;
import com.bumptech.glide.request.target.SimpleTarget;

public class ProfileActivity extends AppCompatActivity implements View.OnClickListener {

    public SharedPreferences settings;
    public SharedPreferences.Editor edit;

    TextView tvName, tvNickname, tvAccountType, tvTel, tvEmail, tvNew;
    EditText etNew;
    Button btnOk;
    ImageView ivIcon, ivClose, ivNicknameRewrite, ivTelRewrite;
    RelativeLayout relative_Profile;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        settings = getSharedPreferences("account", 0);
        edit = settings.edit();
        setContentView(R.layout.activity_profile);

        tvName = (TextView) findViewById(R.id.tvNameValue);
        tvNickname = (TextView) findViewById(R.id.tvNicknameValue);
        tvAccountType = (TextView) findViewById(R.id.tvAccountTypeValue);
        tvTel = (TextView) findViewById(R.id.tvTelValue);
        tvEmail = (TextView) findViewById(R.id.tvEmailValue);
        tvNew = (TextView) findViewById(R.id.tvNew);
        etNew = (EditText) findViewById(R.id.etNew);
        btnOk = (Button) findViewById(R.id.btnOk);
        ivIcon = (ImageView) findViewById(R.id.ivIcon);
        ivClose = (ImageView) findViewById(R.id.ivClose);
        ViewCompat.setElevation(ivClose, 100);
        ivNicknameRewrite = (ImageView) findViewById(R.id.ivNicknameRewrite);
        ivTelRewrite = (ImageView) findViewById(R.id.ivTelRewrite);
        relative_Profile = (RelativeLayout) findViewById(R.id.relative_Profile);

        ivNicknameRewrite.setOnClickListener(this);
        ivTelRewrite.setOnClickListener(this);
        btnOk.setOnClickListener(this);
        ivClose.setOnClickListener(this);

        loadProfile();
        final Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
//        toolbar.setTitle(getString(R.string.actionbar_profile_title));
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }

    private void loadProfile() {
        if (settings.getString("email", "") != "") {
            Glide.with(getApplicationContext())
                    .load(settings.getString("url", ""))
                    .placeholder(R.drawable.loading_page)
                    .dontAnimate()
                    .error(R.drawable.logo)
                    .into(new SimpleTarget<GlideDrawable>() {
                        @Override
                        public void onResourceReady(GlideDrawable resource, GlideAnimation<? super GlideDrawable> glideAnimation) {
                            ivIcon.setImageDrawable(resource.getCurrent());
                        }
                    });
            tvName.setText(settings.getString("name", ""));
            tvNickname.setText(settings.getString("nickName", settings.getString("name", "")));
            tvAccountType.setText(((settings.getString("type", "").contains("google"))? "Google " : "Facebook ") + getString(R.string.settingActivity_accountType_value));
            tvTel.setText(settings.getString("tel", getString(R.string.settingActivity_not_setting)));
            tvEmail.setText(settings.getString("email", ""));
            ivNicknameRewrite.setVisibility(View.VISIBLE);
            ivTelRewrite.setVisibility(View.VISIBLE);
        } else {
            ivIcon.setImageResource(R.drawable.logo);
            tvName.setText(getString(R.string.settingActivity_not_define));
            tvNickname.setText("");
            tvAccountType.setText("");
            tvTel.setText("");
            tvEmail.setText("");
        }
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.ivNicknameRewrite:
                tvNew.setText(getString(R.string.settingActivity_nickname));
                etNew.setInputType(InputType.TYPE_CLASS_TEXT);
                etNew.setFilters(new InputFilter[] {});
                relative_Profile.setVisibility(View.VISIBLE);
                break;
            case R.id.ivTelRewrite:
                tvNew.setText(getString(R.string.settingActivity_tel));
                etNew.setInputType(InputType.TYPE_CLASS_NUMBER);
                etNew.setFilters(new InputFilter[] {new InputFilter.LengthFilter(8)});
                relative_Profile.setVisibility(View.VISIBLE);
                break;
            case R.id.btnOk:
                if (etNew.getText().toString().trim().length() != 0) {
                    if ((tvNew.getText().toString()).equals(getString(R.string.settingActivity_nickname))) {
                        edit.putString("nickName", etNew.getText().toString().trim());
                    } else {
                        edit.putString("tel", etNew.getText().toString().trim());
                    }
                    edit.commit();
                    relative_Profile.setVisibility(View.INVISIBLE);
                    etNew.setText("");
                    loadProfile();
                } else {
                    Toast.makeText(this, getString(R.string.settingActivity_isnotEmpty), Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.ivClose:
                relative_Profile.setVisibility(View.INVISIBLE);
                etNew.setText("");
                break;
        }
    }
}