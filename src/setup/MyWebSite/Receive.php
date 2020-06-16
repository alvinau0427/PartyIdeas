<?php
function send_notification($tokens, $message) {
	$url = 'https://fcm.googleapis.com/fcm/send';
	$api_key = 'AIzaSyCHVFQ7eQB-rBQjG0pOIrfgQZOGzNTzZRM';
	
	$fields = array();
	$fields['data'] = $message;
	$fields['notification'] = $message;
	if (is_array($tokens)) {
		$fields['registration_ids'] = $tokens;
	} else {
		$fields['to'] = $tokens;
	}

	$headers = array
	(
		'Authorization: key=' . $api_key,
		'Content-Type: application/json'
	);
	
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, $url );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYHOST, 0 );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	if ($result === FALSE) {
		die("Failed:" . curl_error($ch));
	}
	curl_close( $ch );
	return $result;
}

require_once ('connection/conn.php');

if (isset($_POST)) {
	if (isset($_POST['account'])) {
		$account = $_POST['account'];
		$sql = "SELECT Token From users WHERE Account = '$account'";
		$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	} else if (isset($_POST['table']) && isset($_POST['id'])) {
		$sql = "SELECT * From {$_POST['table']} WHERE EventID = {$_POST['id']} LIMIT 1";
		$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		$rc = mysqli_fetch_assoc($rs);
		$accountArray = json_decode($rc['JoinedParticipantToken'], true);
		$sql = "SELECT Token From users WHERE";
		for ($i = 0; $i < count($accountArray); $i++) {
			$sql .= " Account = '{$accountArray[$i]['token']}' or";
		}
		$rs = mysqli_query($conn, substr($sql, 0, count($sql) - 3)) or die(mysqli_error($conn));
	} else {
		$sql = "SELECT Token From users WHERE ReceiveNotification = 0";
		$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	}
	
	$tokens = array();
	
	if (mysqli_num_rows($rs) > 0){
		while($rc = mysqli_fetch_assoc($rs)){
			$tokens[] = $rc["Token"];
		}
	}
	
	mysqli_close($conn);
			
	$title = "{$_POST['title']}";
	$body = "{$_POST['body']}";
	
	$message = array("title" => $title, "body" => $body, "icon" => "Photo/logo.png");
	$message_status = send_notification($tokens, $message);
	
	echo $table . $eid;
}
?>