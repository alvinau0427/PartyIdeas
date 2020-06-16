<?php 
	require_once("connection/conn.php");
	
	extract($_GET);
		
	$sql = "UPDATE users SET ReceiveNotification = '$updateStatus' WHERE Token = '$token'";
	$message = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
	echo json_encode($message);

	mysqli_close($conn);
?>