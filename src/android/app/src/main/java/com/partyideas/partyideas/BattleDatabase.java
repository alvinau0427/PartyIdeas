package com.partyideas.partyideas;

import com.google.gson.annotations.SerializedName;

public class BattleDatabase {
    @SerializedName("EventID")
    public int eventID;
    @SerializedName("BoardGameID")
    public int boardGameID;
    @SerializedName("MemberName")
    public String memberName;
    @SerializedName("Account")
    public String account;
    @SerializedName("Contact")
    public String contact;
    @SerializedName("Date")
    public String date;
    @SerializedName("Time")
    public String time;
    @SerializedName("Place")
    public String place;
    @SerializedName("ParticipantRequirement")
    public int requirement;
    @SerializedName("BattleStatus")
    public int status;
    @SerializedName("JoinedParticipant")
    public String joinedParticipant;
    @SerializedName("JoinedParticipantToken")
    public String joinedParticipantToken;

    @SerializedName("BoardGameName")
    public String boardGameName;
    @SerializedName("BoardGameDetail")
    public String boardGameDetail;
    @SerializedName("Year")
    public int year;
    @SerializedName("Price")
    public double price;
    @SerializedName("Quantity")
    public int quantity;
    @SerializedName("Player_Minimum")
    public int minimum;
    @SerializedName("Player_Maximum")
    public int maximum;
    @SerializedName("LimitationAge")
    public int limitationAge;
    @SerializedName("Photo")
    public String photo;

    @SerializedName("location")
    public String location;
}