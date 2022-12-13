
<?php
$servername = "localhost";
$database = "project_know";
$username = "nathan";
$password = "@Bron5a1";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Database Connected Successfully.<br>";

//echo "THIS IS GOOD. THE SITE IS SUCCESSFULLY CONNECTING TO LOCAL DATABASE ON DOCKER CONTAINER."
?>
