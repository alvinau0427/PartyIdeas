<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
		
	$rs = mysqli_query($conn, "SELECT * FROM users WHERE Account = '$account' LIMIT 1") or die(mysqli_error($conn));
	if (mysqli_num_rows($rs) == 1) {
		$rc = mysqli_fetch_assoc($rs);
		if ($token != $rc['Token']) {
			$sql = "DELETE FROM users WHERE Token = '$token'";
			mysqli_query($conn, $sql) or die(mysqli_error($conn));
			$rs = mysqli_query($conn, "SELECT MAX(ID) AS max FROM users") or die(mysqli_error($conn));
			$sql = "ALTER TABLE users AUTO_INCREMENT = 1";
			mysqli_query($conn, $sql) or die(mysqli_error($conn));
			$sql = "UPDATE users SET Token = '" . urldecode($token) . "' WHERE Account = '$account'";
			$message = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		}
	} else {
		$rs = mysqli_query($conn, "SELECT * FROM users WHERE Token = '$token' LIMIT 1") or die(mysqli_error($conn));
		$rc = mysqli_fetch_assoc($rs);
		$sql = "UPDATE users set Account = '$account' WHERE Token = '$token'";
		$message = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	}
	
	echo json_encode($message);

	mysqli_close($conn);
?>