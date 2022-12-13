
<?php

echo "<h2>File Data</h2>";
echo "<h2>Give this walk a name.
And add it as the unique identifier for walks</h2>";
$fileLocation = $_SESSION["uploadFileLocation"];
$run = simplexml_load_file($fileLocation);


//print_r($run);
$totalTimeSeconds = $run->Activities->Activity->Lap->TotalTimeSeconds;
$distance = $run->Activities->Activity->Lap->DistanceMeters;

if (isset($run->Activities->Acitivity->Lap->Calories)){$calories = $run->Activities->Activity->Lap->Calories;}else{$calories = 0;}
if (isset($run->Activities->Activity->Lap->AverageHeartRateBpm->Value)){$averageHeartRateBpm = $run->Activities->Activity->Lap->AverageHeartRateBpm->Value;}else{$averageHeartRateBpm=0;}
if (isset($run->Activities->Activity->Lap->MaximumHeartRateBpm->Value)){$maximumHeartRateBpm = $run->Activities->Activity->Lap->MaximumHeartRateBpm->Value;}else{$maximumHeartRateBpm=0;}


//Average Pace Calculation and convertion
$avgPace = ($totalTimeSeconds/$distance)*1000;//seconds/km
$avgPaceMinutes = floor($avgPace/60);
$avgPaceSeconds = $avgPace%60; if ($avgPaceSeconds < 10){ $avgPaceSeconds="0".(string)$avgPaceSeconds;}


//Initialisers
$totalAscent = 0;
$totalDescent = 0;
$prevAlt = null;
$maxAltitude = null;
$minAltitude = null;
$initialAltitude = null;
$finalAltitude = null;




foreach ($run->Activities->Activity->Lap->Track->Trackpoint as $trackpoint) {
$altitudeMeters = $trackpoint->AltitudeMeters;


//echo "<p>Altitude: $altitudeMeters meters</p></br>";

//Sum altitiude difference
if ($prevAlt) {
$altitudeChange = $altitudeMeters - $prevAlt;
//print_r($altitudeChange);
if ($altitudeChange > 0){
$totalAscent += $altitudeChange;
} else if ($altitudeChange < 0) {
$totalDescent += $altitudeChange;
}

}


//Set Max Altitude
if (!$maxAltitude OR ((string)$maxAltitude < (string)$altitudeMeters)) {
$maxAltitude = $altitudeMeters;
}
//Set Min Altitude
if (!$minAltitude OR ((string)$minAltitude > (string)$altitudeMeters)) {
$minAltitude = $altitudeMeters;

}
//Set Initial Altitiude
if (!$initialAltitude){
$initialAltitude = $altitudeMeters;
}
//Set Final Altitude
if ($altitudeMeters){
$finalAltitude = $altitudeMeters;
}



$prevAlt = $altitudeMeters;
}
$timeHours = "00"; $timeMinutes = "00";
$timeMinutes = floor($totalTimeSeconds / 60); if ($timeMinutes > 60){$timeHours = floor($timeMinutes/60); if ($timeHours < 10){$timeHours = "0".(string)$timeHours;}$timeMinutes%=60;}if ($timeMinutes < 10){$timeMinutes="0".(string)$timeMinutes;}
$timeSeconds = ($totalTimeSeconds % 60); if ($timeSeconds < 10){$timeSeconds = "0".(string)$timeSeconds;}
$distanceKm = round($distance/1000,3);$distance = round((string)$distance, 0);

//print_r($totalTimeSeconds);
echo "<article id='displayData'>";
//    echo "<h4 id='time'>Total Time in seconds: $totalTimeSeconds seconds</h4>";
    echo "<h4>Total Time (HH:MM:SS): $timeHours:$timeMinutes:$timeSeconds</h4>";
    if ($distance > 1000){echo "<h4>Distance: $distanceKm km</h4>"; } else {echo "<h4>Distance: $distance meters</h4>"; }
    echo "<h4>Average Pace: $avgPaceMinutes:$avgPaceSeconds /km</h4>";
    echo "<h4>Calories: $calories</h4>";
    echo "<h4>Average Heart Rate: $averageHeartRateBpm bpm</h4>";
    echo "<h4>Maximum Heart Rate: $maximumHeartRateBpm bpm</h4>";

    //Call Map Func
    echo "<script>Map.publicFunc('$fileLocation')</script>";

    echo "<section id='altitudeStuff'><h2>Altitude Stuff</h2>";

        $ascentThings = [$totalAscent, $totalDescent, $maxAltitude, $minAltitude, $initialAltitude, $finalAltitude];

        for($i=0;$i<count($ascentThings);$i++){
        $ascentThings[$i] = round($ascentThings[$i], 2);
        }
        //$totalAscent = round($totalAscent, 2);
        echo "<p>Total Ascent: $totalAscent meters</p>";
        echo "<p>Total Descent: $totalDescent meters</p>";
        echo "<p>Max Altitude: $maxAltitude meters</p>";
        echo "<p>Min Altitude: $minAltitude meters</p>";
        echo "<p>Inital Altitude: $initialAltitude meters</p>";
        echo "<p>Final Altitude: $finalAltitude meters</p>";
        echo"</section>";

    echo "</article";

    include('htaccess/db_connect.php');

    if (!isset($username)){
        $username = "no_user";
    }
    $query = "INSERT INTO WalksInfo (username, total_time_seconds, distance, avgPace, calories, 
avgHeartRate, maxHeartRate, total_ascent, total_descent, max_altitude, min_altitude, initial_altitude, final_altitude) 
VALUES ('$username', $totalTimeSeconds, $distance, $avgPace, $calories, $averageHeartRateBpm, $maximumHeartRateBpm,
$totalAscent, $totalDescent, $maxAltitude, $minAltitude, $initialAltitude, $finalAltitude)";

    $conn->query($query);
    if ($conn->error) {
        print("Error inserting user into database: " . $conn->error);
    } else {
        echo "<h5>Successfully added walk to database;</h5>";
        $query = "SELECT * FROM WalksInfo WHERE username = '$username'";
        $result = $conn->query($query);
        print_r("You have $result->num_rows walks.");

    }