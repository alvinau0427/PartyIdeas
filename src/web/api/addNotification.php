<?php
    if(isset($_POST['title']) and isset($_POST['body'])){
        extract($_POST);
        require_once("../require/connection/conn.php");
    
        date_default_timezone_set("Asia/Hong_Kong");
        
        $sql = "INSERT INTO notification ( Title , Body , Uid , Name ,Date ) VALUES ( '【PartyIdeas】".urldecode($title)."', '".urldecode($body)."', '$uid', '$name', '". date('Y-m-d h:i',time()) ."' )";
        
        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
        require_once ('getNotification.php');
    }
?>