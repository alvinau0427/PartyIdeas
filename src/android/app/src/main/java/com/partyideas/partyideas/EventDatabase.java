package com.partyideas.partyideas;

import com.google.gson.annotations.SerializedName;

public class EventDatabase {
    @SerializedName("name")
    public String eventName;
    @SerializedName("link")
    public String link;
    @SerializedName("description")
    public String description;
}