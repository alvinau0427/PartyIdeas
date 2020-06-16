<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {

        $id = $_POST['record_id'];

        switch($_POST['current_table']) {
            
        case "gatheringbattle":
            $sql = "SELECT JoinedParticipant, JoinedParticipantToken FROM gatheringbattle WHERE EventID = $id";
            break;
        
        case "privatebooking":
            $sql = "SELECT MemberName, Account FROM privatebooking WHERE BookingID = $id";
            break;
                    
        default:
            die();
    }

    $rs = mysqli_query($conn,$sql);
    
    if(mysqli_num_rows($rs) >= 1) {
        
        $rc = mysqli_fetch_assoc($rs);
        
        echo json_encode($rc);
    }
}
mysqli_close($conn);

?>