package com.partyideas.partyideas;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.DisplayMetrics;
import android.util.Log;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
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
import com.kosalgeek.android.json.JsonConverter;

import org.json.JSONArray;

import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;

public class BoardGameFragment extends Fragment implements Response.Listener<String>, View.OnClickListener {

    MainActivity m = new MainActivity();
    String path = m.getPath();

    final String TAG = this.getClass().getSimpleName();
    String url = null;
    String query = null;
    StringRequest stringRequest = null;
    EditText etSearch;
    RecyclerView recyclerView;
    ActionBar actionBar;
    Button btnFilter;
    View rootView;
    AlertDialog.Builder builder;
    AlertDialog alertDialog;
    TypeAdapter typeAdapter;
    ArrayList<GameType> gameTypes = new ArrayList<GameType>();

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        rootView = inflater.inflate(R.layout.fragment_boardgame_list, container, false);

        etSearch = (EditText) rootView.findViewById(R.id.etSearch);
        etSearch.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                String where = " WHERE boardgame.BoardGameType = boardgametype.ID and boardgame.BoardGameName LIKE '%" + etSearch.getText().toString() + "%' and (boardgame.status = 0 or boardgame.status = 2)";
                showBoardGame(where);
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });

        recyclerView = (RecyclerView) rootView.findViewById(R.id.recycler_view);

        actionBar = ((AppCompatActivity) getActivity()).getSupportActionBar();
        actionBar.setTitle(getString(R.string.navigation_boardgame));

        btnFilter = (Button) rootView.findViewById(R.id.btnFilter);
        btnFilter.setOnClickListener(this);

        showBoardGame(" WHERE boardgame.BoardGameType = boardgametype.ID and (boardgame.status = 0 or boardgame.status = 2)");

        return rootView;
    }

    private void showBoardGame(String s) {
        try {
            query = URLEncoder.encode("SELECT * FROM boardgame, boardgametype" + s + " ORDER BY boardgame.BoardGameID DESC LIMIT 50", "UTF-8");
        }
        catch (Exception e) {
            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_SHORT).show();
        }
        url = path + "api/Selection.php?statement=" + query;

        stringRequest = new StringRequest(Request.Method.GET, url, this, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        });

        MySingleton.getInstance(getActivity()).addToRequestQueue(stringRequest);
    }

    private void showTypeBox() {
        builder = new AlertDialog.Builder(getActivity());
        builder.setCancelable(false);

        View messageView = LayoutInflater.from(getActivity()).inflate(R.layout.fragment_boardgame_typebox, null);
        builder.setView(messageView);

        alertDialog = builder.create();

        Button btnOK = (Button) messageView.findViewById(R.id.btnOK);
        btnOK.setOnClickListener(this);

        Button btnClose = (Button) messageView.findViewById(R.id.btnClose);
        btnClose.setOnClickListener(this);

        ListView lvType = (ListView) messageView.findViewById(R.id.lvType);
        getType(lvType);

        alertDialog.show();

        DisplayMetrics metrics = new DisplayMetrics();
        getActivity().getWindowManager().getDefaultDisplay().getMetrics(metrics);
        alertDialog.getWindow().setLayout((int)(metrics.widthPixels * 0.95), (int)(metrics.heightPixels * 0.75));
    }

    private void getType(final ListView lvType) {
        if (typeAdapter == null) {
            try {
                String query = URLEncoder.encode("SELECT * FROM boardgametype", "UTF-8");
                String url = path + "api/Selection.php?statement=" + query;
                StringRequest stringRequest = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jArray = new JSONArray(response);
                            for (int i = 0; i < jArray.length(); i++) {
                                gameTypes.add(new GameType(jArray.getJSONObject(i).getInt("ID"), jArray.getJSONObject(i).getString("Type"), false));
                            }
                            typeAdapter = new TypeAdapter(getActivity(), gameTypes);

                            getActivity().runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    lvType.setAdapter(typeAdapter);
                                }
                            });
                        }
                        catch (Exception e) {
                            Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                        }
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
                    }
                });

                MySingleton.getInstance(getActivity()).addToRequestQueue(stringRequest);
            }
            catch (Exception e) {
                Toast.makeText(getActivity(), getString(R.string.connect_failed_message), Toast.LENGTH_LONG).show();
            }
        } else {
            getActivity().runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    lvType.setAdapter(typeAdapter);
                }
            });
        }
    }

    @Override
    public void onResponse(String response) {
        Log.d(TAG, response);
        setupRecyclerView(recyclerView, response);
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

    private void setupRecyclerView(RecyclerView recyclerView, String response) {
        try {
            recyclerView.setLayoutManager(new LinearLayoutManager(recyclerView.getContext()));
            recyclerView.setAdapter(new SimpleStringRecyclerViewAdapter(getActivity(),
                    new JsonConverter<BoardGameDatabase>().toArrayList(response, BoardGameDatabase.class)));
        }
        catch (Exception e) {}
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.btnFilter:
                showTypeBox();
                break;
            case R.id.btnOK:
                String where = " WHERE boardgame.BoardGameType = boardgametype.ID and (";
                for (GameType t : typeAdapter.getBox()) {
                    if (t.box) {
                        where += " boardgame.BoardGameType = " + t.id + " or";
                    }
                }
                if (where.compareTo(" WHERE") == 0) {
                    where += " boardgame.status = 0 or boardgame.status = 2)";
                } else {
                    where = where.substring(0, where.length() - 3) + ") and (boardgame.status = 0 or boardgame.status = 2)";
                }
                showBoardGame(where);
                alertDialog.dismiss();
                break;
            case R.id.btnClose:
                alertDialog.dismiss();
                break;
        }
    }

    public class SimpleStringRecyclerViewAdapter extends RecyclerView.Adapter<SimpleStringRecyclerViewAdapter.ViewHolder> {

        private final TypedValue mTypedValue = new TypedValue();
        private int mBackground;
        private List<BoardGameDatabase> mValues;
        Context context;

        public class ViewHolder extends RecyclerView.ViewHolder {
            public final View mView;
            public final ImageView mImageView;
            public final TextView mTextView;

            public ViewHolder(View view) {
                super(view);
                mView = view;
                mImageView = (ImageView) view.findViewById(R.id.civ_avatar_view);
                mTextView = (TextView) view.findViewById(android.R.id.text1);
            }

            @Override
            public String toString() {
                return super.toString() + " '" + mTextView.getText();
            }
        }

        public SimpleStringRecyclerViewAdapter(Context context, List<BoardGameDatabase> items) {
            this.context = context;
            context.getTheme().resolveAttribute(R.attr.selectableItemBackground, mTypedValue, true);
            mBackground = mTypedValue.resourceId;
            mValues = items;
        }

        @Override
        public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
            View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.fragment_boardgame_item, parent, false);
            view.setBackgroundResource(mBackground);
            return new ViewHolder(view);
        }

        @Override
        public void onBindViewHolder(final ViewHolder holder, final int position) {
            holder.mTextView.setText("[" + mValues.get(position).type + "] " + mValues.get(position).boardGameName);
            holder.mView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Context context = v.getContext();
                    Intent intent = new Intent(context, BoardGameFragment_Detail.class);
                    intent.putExtra("id", mValues.get(position).boardGameID);
                    intent.putExtra("photo", mValues.get(position).photo);
                    intent.putExtra("name", mValues.get(position).boardGameName);
                    intent.putExtra("detail", mValues.get(position).boardGameDetail);
                    intent.putExtra("type", mValues.get(position).type);
                    intent.putExtra("price", mValues.get(position).price);
                    intent.putExtra("quantity", mValues.get(position).quantity);
                    intent.putExtra("year", String.valueOf(mValues.get(position).year));
                    intent.putExtra("players", mValues.get(position).minimum + " - " + mValues.get(position).maximum);
                    if (mValues.get(position).limitationAge > 0)
                        intent.putExtra("limitation", mValues.get(position).limitationAge);

                    context.startActivity(intent);
                }
            });

            Glide.with(holder.mImageView.getContext())
                    .load(path + "BoardGameImage/" + mValues.get(position).photo)
                    .placeholder(R.drawable.loading_page)
                    .dontAnimate()
                    .fitCenter()
                    .into(new SimpleTarget<GlideDrawable>() {
                        @Override
                        public void onResourceReady(GlideDrawable resource, GlideAnimation<? super GlideDrawable> glideAnimation) {
                            holder.mImageView.setImageDrawable(resource.getCurrent());
                        }
                    });
        }

        @Override
        public int getItemCount() {
            if (mValues != null)
                return mValues.size();
            else
                return 0;
        }
    }
}