
<?php
if (session_id() === "") {
    session_start();
}
$_SESSION['lastPage'] = $_SERVER['PHP_SELF'];

            if (isset($_SESSION['authenticatedUser'])) {?>
            <div id="logout">
                <?php $username = $_SESSION['authenticatedUser'];
                echo "<p>Welcome, $username </p>";
                //$role = $_SESSION['role'];
                    //  echo"$username $role";
                    ?><span id="logoutUser"></span></p>
                <form id="logoutForm" action="logout.php" method="post">
                    <input type="submit" id="logoutSubmit" value="Logout">
                </form>
            </div>

            <?php } else { ?>
            <div id="user">
                <div id="login">
                    <form id="loginForm" action="login.php" method="post">
                        <label for="loginUser">Username: </label>
                        <input type="text" name="loginUser" id="loginUser" required><br>
                        <label for="loginPassword">Password: </label>
                        <input type="password" name="loginPassword" id="loginPassword" required><br>
                        <?php if (isset($_SESSION['LoginErrorMessage'])){$errorMsg = $_SESSION['LoginErrorMessage']; echo"<p>$errorMsg</p>"; unset($_SESSION['LoginErrorMessage']);}
?>                        <input type="submit" id="loginSubmit" value="Login">
                    </form>
                    <button id="registerButton"><a href="register.php">Register</a></button>
                </div>
            <?php } ?>


<!DOCTYPE html>

<html lang="en">

<head>
    <title>Project_Know</title>
    <meta charset="utf-8">
    <?php
    foreach ($scriptList as $script) {
        echo "<script src='$script'></script>";
    }

    ?></head>

<body>
<h1><a href="index.php">Project Know</a></h1>

