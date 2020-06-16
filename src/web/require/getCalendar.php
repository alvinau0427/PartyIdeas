<meta charset="utf-8" />

<?php
    // require_once('connection/conn.php');
    $sql = "DELETE FROM calendar_event";
    mysqli_query($conn,$sql);
    
    date_default_timezone_set("Asia/Hong_Kong");

    $url = "http://api.meetup.com/partyideas/events";
    $contents = file_get_contents($url);
    // print $contents;
    // var_dump(json_decode($contents, true));
    $data = json_decode($contents, true);
    // print $data[0]['id'];
    // print $data[0]['name'];
    // print $data[0]['time'];
    // print $data[0]['duration'];
    
    foreach($data as $i){
        // print $i['id'].'<br>';
        // print $i['name'].'<br>';
        // print $i['time'].'<br>';
        // print $i['duration'].'<br><br>';
        
        
        // $id = $i['id'];
        $name = urlencode($i['name']);
        $time = $i['time']/1000;
        $duration = $i['duration']/1000;
        $description = urlencode($i['description']);
        
        // print urldecode($description).'<br>';
        
        $d = date('d', $time);
        $m = date('m', $time);
        $y = date('Y', $time);
        $st = date('Hi', $time);
        $et = date('Hi', ($time+$duration));
        
        // print $d.'<br>';
        // print $m.'<br>';
        // print $y.'<br>';
        // print $st.'<br>';
        // print $et.'<br><br>';
        // print $d.'<br>';

        $sql = "insert into calendar_event ( event, description, day, month, year, time_from, time_until ) values ('$name', '$description', $d, $m, $y, $st, $et )";
        $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        
    }
    
    $sql = "select * from gatheringbattle where status = 1";
    $rsgb = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    
    while($rc = mysqli_fetch_assoc($rsgb)){
        $name = urlencode($rc['MemberName'].' 的約戰');;
        // print urldecode($name);
        $sql = "select * from boardgame where BoardGameID = {$rc['BoardGameID']}";
        $rcbg = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        $sql = "select * from location where LocationID = {$rc['Place']}";
        $rcl = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        $jp = json_decode($rc['JoinedParticipant'], true); /// array黎
        $participant = '<table border="1">';
        for ($i = 0; $i < count($jp); $i++) {
            $participant .= "<tr>
                                <td>{$jp[$i]['nickName']} + {$jp[$i]['extraPeople']}</td>
                            </tr>";
        }
        $participant .= '</table>';
        
        $description = urlencode('<img src="../../photo/'.$rcbg['Photo'].'" width="100" height="100"/><br>Board Game : '.$rcbg['BoardGameName']."<br>Host : {$rc['MemberName']} ( {$rc['Account']} )<br>Contact : {$rc['Contact']}<br>Place : {$rcl['Place']}<br>Participant : $participant");
        // print urldecode($description);
        $d = date('d',strtotime($rc['Date']));
        $m = date('m',strtotime($rc['Date']));
        $y = date('Y',strtotime($rc['Date']));
        $st = str_replace(":","",$rc['Time']);
        $et = str_replace(":","",$rc['EndTime']);

        $sql = "insert into calendar_event ( event, description, day, month, year, time_from, time_until ) values ('$name', '$description', $d, $m, $y, $st, $et )";
        $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        
        // print date('m',strtotime($rc['Date'])).'<br>';
        // print str_replace(":","",$rc['Time']);
    }
    
    $sql = "select * from privatebooking where status = 1";
    $rspb = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    
    while($rc = mysqli_fetch_assoc($rspb)){
        $name = urlencode($rc['MemberName'].' 的包埸');
        // print urldecode($name);

        $sql = "select * from location where LocationID = {$rc['Place']}";
        $rcl = mysqli_fetch_assoc(mysqli_query($conn,$sql));

        $description = urlencode("Host : {$rc['MemberName']} ( {$rc['Account']} )<br>Contact : {$rc['Contact']}<br>Place : {$rcl['Place']}<br>Number of participant : {$rc['NumberOfPeople']}<br>Total $ : {$rc['TotalPrice']}<br>Discount : {$rc['Discount']}<br>Remark : {$rc['Remark']}");
        // print urldecode($description);
        $d = date('d',strtotime($rc['Date']));
        $m = date('m',strtotime($rc['Date']));
        $y = date('Y',strtotime($rc['Date']));
        $st = str_replace(":","",$rc['Time']);
        $et = str_replace(":","",$rc['EndTime']);
        
        $sql = "insert into calendar_event ( event, description, day, month, year, time_from, time_until ) values ('$name', '$description', $d, $m, $y, $st, $et )";
        $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        
        // print date('m',strtotime($rc['Date'])).'<br>';
        // print str_replace(":","",$rc['Time']);
    }
?>