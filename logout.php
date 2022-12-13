<?php

if (session_id() === "") {
    session_start();
}

unset($_SESSION['authenticatedUser']);
//unset($_SESSION['role']);

if (isset($_SESSION['lastPage'])){
    $lastPage = $_SESSION['lastPage'];
    header("Location: $lastPage");
    exit;
} else {
    header('Location: index.php');
    exit;
}

