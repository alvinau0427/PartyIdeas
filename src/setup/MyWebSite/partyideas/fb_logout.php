<?php 
	session_start(); 
	session_destroy();
	Header("location:login.php");
?>