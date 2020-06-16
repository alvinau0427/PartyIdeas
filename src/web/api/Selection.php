<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
	
	$sql = "$statement";
	
	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
	while($rc = mysqli_fetch_assoc($rs)){
		$data[] = $rc;
	}
	
	if (isset($data))
		echo json_encode($data);
	else
		echo "";

	mysqli_close($conn);
?>