package com.partyideas.partyideas;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;

import java.util.ArrayList;

public class TypeAdapter extends BaseAdapter {
    Context ctx;
    LayoutInflater lInflater;
    ArrayList<GameType> objects;

    public TypeAdapter(Context context, ArrayList<GameType> types) {
        ctx = context;
        objects = types;
        lInflater = (LayoutInflater) ctx.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return objects.size();
    }

    @Override
    public Object getItem(int position) {
        return objects.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View view = convertView;
        if (view == null) {
            view = lInflater.inflate(R.layout.fragment_boardgame_typebox_item, parent, false);
        }

        GameType t = getType(position);

        CheckBox cbType = (CheckBox) view.findViewById(R.id.checkbox);
        cbType.setText(t.type);
        cbType.setOnCheckedChangeListener(myCheckChangList);
        cbType.setTag(position);
        cbType.setChecked(t.box);
        return view;
    }

    public GameType getType(int position) {
        return ((GameType) getItem(position));
    }

    public ArrayList<GameType> getBox() {
        ArrayList<GameType> box = new ArrayList<GameType>();
        for (GameType p : objects) {
            if (p.box)
                box.add(p);
        }
        return box;
    }

    public CompoundButton.OnCheckedChangeListener myCheckChangList = new CompoundButton.OnCheckedChangeListener() {
        public void onCheckedChanged(CompoundButton buttonView,
                                     boolean isChecked) {
            getType((Integer) buttonView.getTag()).box = isChecked;
        }
    };
}
