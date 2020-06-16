<?php
    $hostname = "127.0.0.1";
    $username = "root";
    $pwd = "";
    $db = "partyideas_db";
    $conn = mysqli_connect($hostname, $username, $pwd, $db) or die(mysqli_connect_error());
    mysqli_query($conn,"SET NAMES utf8");
?>