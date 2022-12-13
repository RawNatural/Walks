<?php
if (!isset($_SESSION['authenticatedUser'])){
    //header("location:index.php");
}
?>


<link rel="stylesheet" href="main.css">
<?php
$scriptList = array('js/ProfileEdit.js', 'js/jquery3.3.js');
include('header.php');

$username = $_SESSION['authenticatedUser'];
echo "Hello, $username. This is your profile";

?>
<h2>Update Profile</h2>
<button id="editButton">edit</button>




<section id="editProfileSec">
    <fieldset id="editProfileFieldset">
        <legend>Edit User Details</legend>

        <form id="editProfileForm">
            <?php
            $usersTextRows = ["Email_Address", "Mobile_Number", "Address", "Suburb", "City", "Country", "Zip_Code",
                "Height", "Weight", "Fitness_Level"];

            //Display label and respective input field for each user Input thing
            foreach($usersTextRows as $userTextRow) {

                if (!($userTextRow == "Fitness_Level")) {
                    $type = "text";
                    if ($userTextRow == "Birth_Date") {
                        $type = "date";
                    }
                    $stringNoUnderscore = str_replace("_", " ", $userTextRow);
                    echo "<label for='new$userTextRow' class='editProfileLabel'>$stringNoUnderscore</label>";

                    echo "<input type=$type name='new$userTextRow' id='new$userTextRow' class='editProfileInput' disabled>";

                } else {
                echo "
            <label for='new$userTextRow' class='editProfileLabel'>Fitness Level</label>
            <select id='new$userTextRow' name='new$userTextRow' class='editProfileInput' disabled>
            <option value='' selected disabled hidden>Select Personal Fitness Level</option>";

                    $options = ["Low", "Below Average", "Average", "Above Average", "High", "Extreme", "Elite"];
                    foreach ($options as $option) {
                        echo "<option value=$option>$option</option>";
                    }

                    echo "</select>";

            }
            }?>

            <input value='Update' id="editProfileButton" type="submit" disabled>
        </form>
    </fieldset>

</section>

<?php


$listOfChanges = [];
$listOfParametersToChange = [];

foreach($usersTextRows as $userTextRow){
    if(isset($_GET["new$userTextRow"])) {
        if ($_GET["new$userTextRow"] != "") {
            array_push($listOfChanges, $_GET["new$userTextRow"]);
            array_push($listOfParametersToChange, $userTextRow);

            //$listOfParametersToChange =
            unset($_GET["new$userTextRow"]);
        }
    }
}

//print_r($listOfChanges);
//print_r($listOfParametersToChange);


include('htaccess/db_connect.php');

$query = "UPDATE Users SET ";
$i = 0;
foreach ($listOfParametersToChange as $change) {
    $change = strtolower($change);
    $query .= "$change = '$listOfChanges[$i]' ";
    if ($i < count($listOfChanges)-1){
        $query .= ", ";
    }
    $i++;
}


$authUser = $_SESSION['authenticatedUser'];
$query .= "WHERE username = '$authUser';";


$conn->query($query);

if ($conn->error) {
    //print("Error inserting user into database: " . $conn->error);
} else {
    print_r("Profile Successfully updated");
}

