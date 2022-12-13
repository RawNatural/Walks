<?php


if (session_id() === "") {
    session_start();
}

include_once('htaccess/db_connect.php');

$username = $conn->real_escape_string($_POST['loginUser']);
$password = $conn->real_escape_string($_POST['loginPassword']);



//                                                CHANGE THIS BELOW TO SHA('$password');
$query = "SELECT * FROM Users WHERE username = '$username' AND password = SHA('$password');";
$result = $conn->query($query);
if ($conn->error) {
    echo "<p>ERROR: Could not update database</p>\n";
} else {
    if($result->num_rows === 0) {
        $_SESSION["LoginErrorMessage"] = "Incorrect Username AND/OR Password";
    } else {
        $_SESSION['authenticatedUser'] = "$username";
        unset($_SESSION["LoginErrorMessage"]);
    }
}


$conn->close();

if (isset($_SESSION['lastPage'])){
    $lastPage = $_SESSION['lastPage'];
    header("Location: $lastPage");
    exit;
} else {
    header('Location: index.php');
    exit;
}
?>