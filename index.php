<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="leaflet.css">
<?php $scriptList = array('js/jquery3.3.js', 'js/leaflet.js', 'js/Map.js');
include('header.php'); ?>




<?php
if (isset($_SESSION['uploadFileLocation'])){ //OR IF database holds this files data

    include('interpretTcx.php');

    unset($_SESSION['uploadFileLocation']);
    //unlink($fileLocation);



?>


<main>


    <section id="mapSection">
        <h2>This is a Map</h2>
        <figure id="map">
        </figure>
    </section>
    <?php } ?>

    <nav>
        <ul>
            <li><a href="profile.php">My Profile</a> </li>
            <li>See all walks here: <a href='allWalks.php'><input type='button' value='See all walks'></a></li>
        </ul>
    </nav>


    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select file to upload: (acceptable types: .tcx)
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>



    <section id="latlongs">
        <p id="displayFile"></p>

    </section>
</main>

