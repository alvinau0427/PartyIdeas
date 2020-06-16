<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
	
	$sql = "INSERT INTO privatebooking (MemberName, Account, Contact, Date, Time, EndTime, Place, NumberOfPeople, TotalPrice, Discount, Remark, Photo, Status) VALUES ('$name', '$account', '$tel', '$date', '$startTime', '$endTime', $place, $num, $totalPrice, $discount, '$remark', null, 0)";
	
	$message = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo json_encode($message);
	
	mysqli_close($conn);
?>