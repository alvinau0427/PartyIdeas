<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {
    
    $validator = array('success' => false,
                    'messages' => array());
    
    $id = $_POST['record_id'];
    $status = $_POST['record_status'];
    
    switch($_POST['current_table']) {
        
        case "gatheringbattle":
            $sql = "UPDATE gatheringbattle SET Status = '{$status}' WHERE EventID = $id";
            break;
        
        case "privatebooking":
            $sql = "UPDATE privatebooking SET Status = '{$status}' WHERE BookingID = $id";
            break;
        
        case "boardgamebooking":
            $sql = "UPDATE boardgamebooking SET Status = '{$status}' WHERE BookingID = $id";
            break;
            
        default:
            die();
    }
    
    
    mysqli_query($conn,$sql);
    
    if(mysqli_affected_rows($conn) >= 1) {
        
        $validator['success'] = true;
        if($status == 2)
            $validator['messages'] = "成功拒絕申請 !";
        else
            $validator['messages'] = "成功接受申請 !";

    } else {
        
        $validator['success'] = false;
        $validator['messages'] = "Error !";

    }
    
    echo json_encode($validator);
}

mysqli_close($conn);
?>