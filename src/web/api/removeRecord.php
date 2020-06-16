<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {
    
    $validator = array('success' => false,
                    'messages' => array());
    
    $id = $_POST['record_id'];
    
    switch($_POST['current_table']) {
        case "admin":
            $sql = "DELETE FROM admin WHERE AdminID = '{$id}'";
            break;
        
        case "blacklist":
            $sql = "DELETE FROM blacklist WHERE BlacklistID = '{$id}'";
            break;
                    
        case "boardgame":
            $sql = "DELETE FROM boardgame WHERE BoardGameID = '{$id}'";
            break;
                    
        case "boardgamebooking":
            $sql = "DELETE FROM boardgamebooking WHERE BookingID = '{$id}'";
            break;
            
        case "boardgametype":
            $sql = "DELETE FROM boardgametype WHERE ID = '{$id}'";
            break;
            
        case "gatheringbattle":
            $sql = "DELETE FROM gatheringbattle WHERE EventID = '{$id}'";
            break;
                    
        case "location":
            $sql = "DELETE FROM location WHERE LocationID = '{$id}'";
            break;
                    
        case "notification":
            $sql = "DELETE FROM notification WHERE NotificationID = '{$id}'";
            break;
                    
        case "photo":
            $sql = "DELETE FROM photo WHERE ID = '{$id}'";
            break;
                    
        case "privatebooking":
            $sql = "DELETE FROM privatebooking WHERE BookingID = '{$id}'";
            break;
                                
        case "users":
            $sql = "DELETE FROM users WHERE ID = '{$id}'";
            break;
        
        default:
            die();
    }
    
    
    mysqli_query($conn,$sql);
    
    if(mysqli_affected_rows($conn) >= 1) {
        
        $validator['success'] = true;
        $validator['messages'] = "成功移除紀錄 !";
		mysqli_query($conn, "ALTER TABLE {$_POST['current_table']} AUTO_INCREMENT = 1") or die(mysqli_error($conn));

    } else {
        
        $validator['success'] = false;
        $validator['messages'] = "Error !";

    }
    
    echo json_encode($validator);
}

mysqli_close($conn);
?>