<?php
if (session_id() === "") {
    session_start();
}
?>

<?php

echo "<h1>File Read</h1>";

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//Check file size?
/**if ($_FILES["fileToUpload"]["size"] > 500000) {
echo "Sorry, your file is too large.";
$uploadOk = 0;
}*/

//Check file format
if($fileType != "tcx" && $fileType != "gpx"){
    $_SESSION['error_message'] = "Sorry, only tcx and gpx files are allowed.";
    $uploadOk = 0;
}

//Check if upload OK, then upload file
if ($uploadOk == 1){
    (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file));
}

$_SESSION["uploadFileLocation"] = $target_file;

header("Location: index.php");