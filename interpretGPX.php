<link rel="stylesheet" href="main.css">
<?php $scriptList = array('js/jquery3.3.js');
include('header.php');?>

<?php


$xmlFile = simplexml_load_file("uploads/TNC_Day_1_Watch_Data.gpx");

$name = $xmlFile->trk->name;
$type = $xmlFile->trk->type;

echo "<h2>Name: $name</h2>";
echo "<h2>Type: $type</h2>";



$trkpt = $xmlFile->trk->trkseg->trkpt;
$trk = $xmlFile->trk;

//print_r($trk);

$latitudes = [];
$longitudes = [];
$elevations = [];
$times = [];

foreach ($trkpt as $trkpts) {
    //print_r($trkpts);
    echo "<br>";
    $lat = $trkpts['lat'];
    array_push($latitudes, $lat);
}

print_r($latitudes);
//print_r($trk['lat']);

//print_r($trk);

//for

print_r($trkpt['lat']);




?>