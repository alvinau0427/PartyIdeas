<?php 
	require_once ('../require/connection/conn.php');
	
	if(isset($_POST)) {
		
		$id = $_POST['record_id'];
		
		$rs1 = mysqli_query($conn, "SELECT * FROM boardgamebooking WHERE BookingID = $id LIMIT 1") or die(mysqli_error($conn));
		$rc1 = mysqli_fetch_assoc($rs1);
		
		$rs2 = mysqli_query($conn, "SELECT * FROM boardgame WHERE BoardGameID = {$rc1['BoardGameID']} LIMIT 1") or die(mysqli_error($conn));
		$rc2 = mysqli_fetch_assoc($rs2);
		
		if ($rc2['Quantity'] >= $rc1['Quantity']) {
			$sql = "UPDATE boardgame SET Quantity = " . ($rc2['Quantity'] - $rc1['Quantity']) . " WHERE BoardGameID = {$rc1['BoardGameID']}";
			mysqli_query($conn, $sql) or die(mysqli_error($conn));
		}
	}
	mysqli_close($conn);
?>