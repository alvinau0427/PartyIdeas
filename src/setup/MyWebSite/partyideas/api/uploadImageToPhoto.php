<?php
$ds = DIRECTORY_SEPARATOR;  //1

if (!is_dir('../Photo')) {
    mkdir('../Photo', 0755, true);
}

$storeFolder = '../Photo';   //2

if (!empty($_FILES)) {
    
    require_once ('../require/connection/conn.php');
    $sql = "INSERT INTO photo(PhotoName, Status) VALUES('".$_FILES['file']['name']."' , '0' )";
    mysqli_query($conn,$sql);
    mysqli_close($conn);

    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
}
?>

<?php

// if (!is_dir('image/')) {
//     mkdir('image/', 0755, true);
// }
// $target_dir = "image/";

// $target_file = $target_dir . basename($_FILES['file']['name']);

// $uploadOk = 1;

// $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

//     $check = getimagesize($_FILES['file']['tmp_name']);
    
//     if($check !== false) {
//         echo "File is an image - " . $check["mime"] . ".";
//         $uploadOk = 1;
//     } else {
//         echo "File is not an image.";
//         $uploadOk = 0;
//     }

// if (file_exists($target_file)) {
//     echo "Sorry, file already exists.<br>";
//     $uploadOk = 0;
// }

// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
//     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
//     $uploadOk = 0;
// }

// if ($uploadOk == 0) {
//     echo "Sorry, your file was not uploaded.<br>";
// } else {
//     if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
//         echo "The file ". basename($_FILES["file"]["name"]). "has been uploaded.<br>";
//     } else {
//         echo "Sorry, there was an error uploading your file.<br>";
//     }
// }

?>