<?php
$ds = DIRECTORY_SEPARATOR;  //1

if (!is_dir('../BoardGameImage')) {
    mkdir('../BoardGameImage', 0755, true);
}

$storeFolder = '../BoardGameImage';   //2
 
if (!empty($_FILES)) {
    
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
     
}
?>