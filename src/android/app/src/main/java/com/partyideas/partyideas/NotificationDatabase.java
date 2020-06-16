package com.partyideas.partyideas;

import com.google.gson.annotations.SerializedName;

public class NotificationDatabase {
    @SerializedName("NotificationID")
    public int notificationID;
    @SerializedName("Title")
    public String title;
    @SerializedName("Body")
    public String body;
    @SerializedName("Uid")
    public String uid;
    @SerializedName("Name")
    public String name;
    @SerializedName("Date")
    public String date;
}