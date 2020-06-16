<?php 
	require_once ('../require/connection/conn.php');
	
	extract($_GET);
	
	$rs = mysqli_query($conn, "SELECT * FROM gatheringbattle, boardgame WHERE gatheringbattle.BoardGameID = boardgame.BoardGameID and gatheringbattle.EventID = $eventID LIMIT 1") or die(mysqli_error($conn));
	if (mysqli_num_rows($rs) > 0) {

		$rc = mysqli_fetch_assoc($rs);
		$url = "{$_SERVER['SERVER_NAME']}/MyWebSite/Receive.php";
		$fields = array('table' => 'gatheringbattle',
                        'id' => $eventID,
						'title' => urlencode("約戰房間[{$rc['BoardGameName']}]"),
						'body' => urlencode("房間({$rc['Date']} " . substr($rc['Time'], 0, 5) . ")已被房主取消"));
		foreach($fields as $key=>$value) { 
			$fields_string .= $key . '=' . $value . '&'; 
		}
		rtrim($fields_string, '&');

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		$result = curl_exec($ch);

		curl_close($ch);
		mysqli_query($conn, "DELETE FROM gatheringbattle WHERE EventID = $eventID") or die(mysqli_error($conn));
		mysqli_query($conn, "ALTER TABLE gatheringbattle AUTO_INCREMENT = 1") or die(mysqli_error($conn));
		echo "true";
	} else {
		echo "false";
	}
	mysqli_close($conn);
?>