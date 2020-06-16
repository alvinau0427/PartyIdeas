<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
	
	$sql = "INSERT INTO boardgamebooking (BoardGameID, Quantity, TotalPrice, MemberName, Contact, OrderDate, OrderTime, ReceiptDate, ReceiptTime, Status) VALUES ($boardgameID, $quantity, $totalprice, '$membername', '$contact', '$orderdate', '$ordertime', null, null, 0)";
	
	$message = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo json_encode($message);
	
	mysqli_close($conn);
?>