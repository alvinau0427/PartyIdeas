<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {
    
    $validator = array('success' => false,
                    'messages' => array());
    
    $account = $_POST['account'];
    $adminAccount = $_POST['adminAccount'];
    
    $sql = "SELECT AdminID FROM admin WHERE LoginAccount = '$adminAccount'";
    
    $rs = mysqli_query($conn,$sql);
    
    if(mysqli_num_rows($rs) >= 1) { // check is admin
        
        $rc = mysqli_fetch_assoc($rs);
        $adminId = $rc['AdminID'];
        
        $sql = "SELECT * FROM blacklist WHERE Account = '$account'";
        mysqli_free_result($rs);
        $rs = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($rs) >= 1) {
            $rc = mysqli_fetch_assoc($rs);
            $sql = "UPDATE blacklist SET Status = '1' WHERE BlacklistID = '{$rc['BlacklistID']}'";
        } else {
            $sql = "INSERT INTO blacklist(Account, Status, BlackListDate, Admin) VALUES('$account', '0', '".date("Y-m-d")."', '$adminId')";
        }
        
        
        mysqli_query($conn,$sql); // insert or update to database
        
        if(mysqli_affected_rows($conn) >= 1) {
        
            $validator['success'] = true;
            $validator['messages'] = "成功加入至黑名單，請查閱blacklist數據庫!";
    
        } else {
            
            $validator['success'] = false;
            $validator['messages'] = "Error !";
    
        }

    } else {
        
        $validator['success'] = false;
        $validator['messages'] = "Error 你不是admin!";

    }
    
    echo json_encode($validator);
}

mysqli_close($conn);
?>