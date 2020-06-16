package com.partyideas.partyideas;

import com.google.gson.annotations.SerializedName;

public class BoardGameDatabase {
    @SerializedName("BoardGameID")
    public int boardGameID;
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

    @SerializedName("ID")
    public int id;
    @SerializedName("Type")
    public String type;
}
