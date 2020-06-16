package com.partyideas.partyideas;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.widget.TextView;

public class ViewPagerAdapter extends FragmentStatePagerAdapter {

    CharSequence titles[];
    int numbOfTabs;
    TextView showMonthView;

    public ViewPagerAdapter(FragmentManager fm, CharSequence titles[], int mNumbOfTabs, TextView textView) {
        super(fm);
        this.titles = titles;
        this.numbOfTabs = mNumbOfTabs;
        showMonthView = textView;
    }

    @Override
    public Fragment getItem(int position) {
        CompactCalendarTab compactCalendarTab = new CompactCalendarTab();
        compactCalendarTab.setShowView(showMonthView);
        return compactCalendarTab;
    }

    @Override
    public CharSequence getPageTitle(int position) {
        return titles[position];
    }

    @Override
    public int getCount() {
        return numbOfTabs;
    }
}