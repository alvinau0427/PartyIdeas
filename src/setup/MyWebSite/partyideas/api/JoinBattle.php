<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
		
	$rs = mysqli_query($conn, "SELECT * FROM blacklist WHERE Account = '$token'") or die(mysqli_error($conn));
	if ($rc = mysqli_fetch_assoc($rs)) {
		if ($rc['Status'] == 2) {
			echo "blacklisted";
		}
	} else {
		$rs = mysqli_query($conn, "SELECT * FROM gatheringbattle WHERE EventID = $eventID") or die(mysqli_error($conn));
		$rc = mysqli_fetch_assoc($rs);
		if (urlencode($user) == $rc['Account']) {
			echo "hoster";
		} else {
			$participant = json_decode($rc['JoinedParticipant'], true);
			$participantToken = json_decode($rc['JoinedParticipantToken'], true);
			if (checkUser($user, $participantToken)) {
				$participant[] = array("nickName" => urlencode($nickName), "extraPeople" => $extraPeople);
				$participantToken[] = array("token" => "$user");
				$count = 0;
				for($i = 0; $i < count($participant); $i++) {
					if ($participant[$i]['extraPeople'] != '') {
						$count += 1 + $participant[$i]["extraPeople"];
					} else {
						$count += 1;
					}
				}
				
				if ($rc['ParticipantRequirement'] == $count) {
					mysqli_query($conn, "UPDATE gatheringbattle SET Status = 0 WHERE EventID = $eventID") or die(mysqli_error($conn));
				}
				
				$sql = "UPDATE gatheringbattle SET JoinedParticipant = '" . json_encode($participant) . "', JoinedParticipantToken = '" . json_encode($participantToken) . "' WHERE EventID = $eventID";

				$message = mysqli_query($conn, $sql) or die(mysqli_error($conn));
				echo json_encode($message);
			} else {
				echo "joined";
			}
		}
	}

	mysqli_close($conn);
	
	function checkUser($user, $joinedTokens) {
		for($i = 0; $i < count($joinedTokens); $i++) {
			if ($user == $joinedTokens[$i]["token"]) {
				return false;
			}
		}
		return true;
	}
?>