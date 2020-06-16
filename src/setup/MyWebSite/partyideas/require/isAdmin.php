<?php
    
    $sql = "select * from admin where LoginAccount = '"."{$user['email']}"."'";
    $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    
    $_SESSION['isAdmin'] = 0;
    
    if(mysqli_num_rows($rs) == 1)
        $_SESSION['isAdmin'] = 1;
        

?>