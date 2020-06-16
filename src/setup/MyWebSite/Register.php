<?php

	if (isset($_GET["Token"])){
		$token = $_GET["Token"];
		
		require_once("connection/conn.php");
		
		$query = "INSERT INTO users (Token, Account, ReceiveNotification) VALUES ('$token', NULL, '0')";
		
		mysqli_query($conn, $query);
		
		mysqli_close($conn);
	}
?>