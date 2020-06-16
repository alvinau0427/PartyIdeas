<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {

        switch($_POST['current_table']) {
            
        case "gatheringbattle":
            $sql = "SELECT * FROM message WHERE ID = 1";
            break;
        
        case "privatebooking":
            $sql = "SELECT * FROM message WHERE ID = 2";
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