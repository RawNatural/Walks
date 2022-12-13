<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<fieldset id="registerFieldset">
    <legend>New User Details</legend>

    <form id="registerForm">
    <?php

    $usersTextRows = ["First_Name", "Last_Name", "Username", "Password", "Confirm_Password", "Email_Address", "Mobile_Number", "Address", "Suburb", "City", "Country", "Zip_Code", "Gender",
        "Birth_Date", "Height_(cm)", "Weight_(kg)", "Assumed_Fitness_Level"];

    //Display label and respective input field for each user Input thing
    foreach($usersTextRows as $userTextRow) {

        if (!($userTextRow == "Assumed_Fitness_Level")) {
            $type = "text";
            if ($userTextRow == "Birth_Date") {
                $type = "date";
            }
            if ($userTextRow == "Password" OR $userTextRow == "Confirm_Password") {
                $type = "password";
            }
            $stringNoUnderscore = str_replace("_", " ", $userTextRow);
            echo "<label for=$userTextRow class='registerLabel'>$stringNoUnderscore</label>";
            if ($userTextRow != "Gender") {
                echo "<input type=$type name=$userTextRow id=$userTextRow class='registerInput' required>";
            } else {
                echo "<select id=$userTextRow name=$userTextRow class='registerInput' required>
            <option value='' selected disabled hidden>Select Gender</option>";
                $options = ["Male", "Female", "Other", "Prefer Not to Say"];
                foreach ($options as $option) {
                    echo "<option value=$option>$option</option>";
                }
                echo "</select>";
            }
        } else {
            echo "
            <label for=$userTextRow id=$userTextRow class='registerLabel'>Assumed Fitness Level</label>
            <select id=$userTextRow name=$userTextRow class='registerInput' required>
            <option value='' selected disabled hidden>Select Personal Fitness Level</option>";
            $options = ["Low", "Below Average", "Average", "Above Average", "High", "Extreme", "Elite"];
            foreach ($options as $option) {
                echo "<option value=$option>$option</option>";
            }

            echo "</select>";

        }
    }?>

    <input type="submit">
    </form>
</fieldset>


<?php
// DATABASE TINGS
include('htaccess/db_connect.php');

$formOK = false;

if (isset($_GET["Username"])) {
    $formOK = true;

    // The part that checks if email and mobile already have an account: ?>
    <?php
    //MAKE THIS PART MORE EFFICIENT LATER

    $email = $_GET["Email_Address"];
    // Perform query to see how many users there are with given username
    $result = $conn -> query("SELECT * FROM Users WHERE email_address = '$email'");
    if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    if ($result->num_rows === 0) {
        // OK, there is no user with that username
        print("You can use that email! ");
    } else {
        $formOK = false;
        print("There is already a user associated with that email.<br>");
    }
    $mobile = $_GET["Mobile_Number"];
    // Perform query to see how many users there are with given username
    $result = $conn -> query("SELECT * FROM Users WHERE mobile_number = '$mobile'");
    if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    if ($result->num_rows === 0) {
        // OK, there is no user with that username
        echo"<p>You can use that mobile number!<br></p>";
    } else {
        $formOK = false;
        print("There is already a user associated with that mobile number.<br>");
    }
    $username = $_GET["Username"];
    // Perform query to see how many users there are with given username
    $result = $conn -> query("SELECT * FROM Users WHERE username = '$username'");
    if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    if ($result->num_rows === 0) {
        // OK, there is no user with that username
        echo"<p>You can use that username!<br></p>";
    } else {
        $formOK = false;
        print("There is already a user associated with that username.<br>");
    }

    $password = $_GET['Password'];
    $password2 = $_GET['Confirm_Password'];
    if ($password != $password2) {
        $formOK = false;
        print("Passwords do not match. ");
    }
    if (strlen($password) < 8) {
        print("Password needs to be at least 8 characters. ");
        $formOK = false;
    }

    ?>

    <?php
    if ($formOK) {
        //continue
        $inputItems = []; //Format inputs.
        for ($i = 0;$i<count($usersTextRows);$i++){
            if ($usersTextRows[$i] != "Password") {
                if ($usersTextRows[$i] != "Confirm_Password") {
                    array_push($inputItems, $_GET[$usersTextRows[$i]]);
                    print_r($usersTextRows[$i]);
                }
            }
        }

        $inputItemsString = implode('", "', $inputItems);


        $insertQuery = "INSERT INTO Users (first_name, last_name, username, email_address, mobile_number, address, suburb, city, country, zip_code, gender, birth_date, height, weight, fitness_level, password)
        VALUES (".'"'.$inputItemsString.'"'.", SHA('$password'))";
        $conn->query($insertQuery);

        if ($conn->error) {
            print("Error inserting user into database: " . $conn->error);
        } else {
            print("Success! User inserted into Database. <br>");
            $result = $conn -> query("SELECT * FROM Users");
            print("Amount of users =". $result->num_rows. "<br>");
            $_SESSION['authenticatedUser'] = $username;
            header('location: index.php');


        }
        $result->free();
        $conn->close();
    }
}
?>


</body>
</html>
