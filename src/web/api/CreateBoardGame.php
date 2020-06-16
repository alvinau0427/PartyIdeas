<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
		
	$rs1 = mysqli_query($conn, "SELECT * FROM gatheringbattle WHERE Account = '$account' and Date >= '" . date("Y-m-d") . "'") or die(mysqli_error($conn));
	
	$rs2 = mysqli_query($conn, "SELECT * FROM gatheringbattle WHERE Account = '$account' and Date = '$date'") or die(mysqli_error($conn));
	
	if (mysqli_num_rows($rs1) < 2) {
		if (mysqli_num_rows($rs2) != 1) {
			$participant[] = array("nickName" => urlencode($nickName), "extraPeople" => "");
			$participantToken[] = array("token" => "$account");
			$sql = "INSERT INTO gatheringbattle (BoardGameID, MemberName, Account, Contact, Date, Time, EndTime, Place, ParticipantRequirement, Status, JoinedParticipant, JoinedParticipantToken) VALUES ($gameID, '$nickName', '$account', '$tel', '$date', '$startTime', '$endTime', $location, $num, -1, '". json_encode($participant) ."', '". json_encode($participantToken) ."')";
			$message = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			echo json_encode($message);
		} else {
			echo "thatdaycreated";
		}
	} else {
		echo "has2room";
	}
	
	mysqli_close($conn);
?>