<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {

    $id = $_POST['record_id'];

    switch($_POST['current_table']) {
        case "admin":
            $sql = "SELECT * FROM admin WHERE AdminID = $id";
            break;
        
        case "blacklist":
            $sql = "SELECT * FROM blacklist WHERE BlacklistID = $id";
            break;
                    
        case "boardgame":
            $sql = "SELECT * FROM boardgame WHERE BoardGameID = $id";
            break;
                    
        case "boardgamebooking":
            $sql = "SELECT * FROM boardgamebooking WHERE BookingID = $id";
            break;
            
        case "boardgametype":
            $sql = "SELECT * FROM boardgametype WHERE ID = $id";
            break;
                    
        case "gatheringbattle":
            $sql = "SELECT * FROM gatheringbattle WHERE EventID = $id";
            break;

        case "location":
            $sql = "SELECT * FROM location WHERE LocationID = $id";
            break;
                    
        case "notification":
            $sql = "SELECT * FROM notification WHERE NotificationID = $id";
            break;
            
        case "photo":
            $sql = "SELECT * FROM photo WHERE ID = $id";
            break;
                    
        case "privatebooking":
            $sql = "SELECT * FROM privatebooking WHERE BookingID = $id";
            break;
                                
        case "users":
            $sql = "SELECT * FROM users WHERE ID = $id";
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