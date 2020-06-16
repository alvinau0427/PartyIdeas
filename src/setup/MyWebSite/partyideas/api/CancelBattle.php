<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
	
	$rs = mysqli_query($conn, "SELECT * FROM gatheringbattle WHERE EventID = $eventID") or die(mysqli_error($conn));
	$rc = mysqli_fetch_assoc($rs);
	$participant = json_decode($rc['JoinedParticipant'], true);
	$participantToken = json_decode($rc['JoinedParticipantToken'], true);
	for($i = 0; $i < count($participantToken); $i++) {
		if ($participantToken[$i]["token"] == $user) {
			unset($participant[$i]);
			unset($participantToken[$i]);
			$message = mysqli_query($conn, "UPDATE gatheringbattle SET JoinedParticipant = '" . json_encode($participant) . "', JoinedParticipantToken = '" . json_encode($participantToken) . "' WHERE EventID = $eventID") or die(mysqli_error($conn));

			if ($rc['Status'] == 0) {
				mysqli_query($conn, "UPDATE gatheringbattle SET Status = -1 WHERE EventID = $eventID") or die(mysqli_error($conn));
			}
			die(json_encode($message));
		}
	}
	echo "cancelled";
	mysqli_close($conn);
?>