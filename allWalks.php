<link rel="stylesheet" href="main.css">
<?php $scriptList = array('js/jquery3.3.js');
include('header.php');?>


<?php

include_once('htaccess/db_connect.php');


if(!isset($username)){
    $username = 'no_name';
}

$query = ("SELECT * FROM WalksInfo WHERE username = '$username'");

$result = $conn->query($query);
$numWalks = $result->num_rows;
print_r("Number of Walks for $username = ". $numWalks);

echo "<nav>";
echo "<h2>All Walks for $username</h2>";
echo "<ul class = 'outerUL'>";

$usefulRows = ['walk_id', 'total_time_seconds', 'distance', 'avgPace'];
for($i=1;$i<=$numWalks;$i++){
    while ($row = $result->fetch_assoc()) {
        $query = ("SELECT * FROM WalksInfo WHERE username = '$username' AND walk_id = $i");
        echo "<li class='outerList'><ul class='innerUL'><a href='index.php'>";
        foreach($usefulRows as $usefulRow){
            echo "<li class='innerList'>$usefulRow : " . $row["$usefulRow"] . "</li>";
        }
        echo "</ul></li>";


        //echo "<p>"
    }
}
?>
</ul>
</nav>