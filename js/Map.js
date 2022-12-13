
var Map = (function () {
    "use strict";

    var pub = {};

    var map;

    // Called when file is added.
    function interpretFile(evt) {

        let fileReader = new FileReader();
        let fileString = evt.target.files[0]; // can change to foreach to read multiple different files separately
        if (fileString) {
            fileReader.readAsText(fileString);
        }
        fileReader.addEventListener("load", () => {

            //On file load, sets the read file into session storage - so that it can be used after the page is refreshed. (php refresh).
            var fileReaderResult = fileReader.result;
            window.sessionStorage.setItem('fileUploaded', fileReaderResult);
        }, false);
    }

    // input tcx file and get out the lat and longs
    function getLatLongs(s) {

        //Reads xml input file
        let source = ( new DOMParser() ).parseFromString    (s, "application/xml" );

        //Reads certain xml elements.
        let latitudes = source.getElementsByTagName("LatitudeDegrees");
        let longitudes = source.getElementsByTagName('LongitudeDegrees');
        let positionLength = source.getElementsByTagName('Position').length;

        let altitudes = source.getElementsByTagName('Time');

        //initializers
        var sumLats = 0.0;
        var sumLongs = 0.0;
        var latLongDoubleValueArray = [];
        var maxLat = 0.0;
        var minLat = 0.0; // Use these values to figure out the scale of zoom to use on map.

        //iterates through lats and longs, calculates sums and averages, and creates double array of lats and longs.
        for (let i = 0; i < positionLength; i++) {
            sumLats += parseFloat(latitudes[i].innerHTML);
            sumLongs += parseFloat(longitudes[i].innerHTML);
            latLongDoubleValueArray.push([parseFloat(latitudes[i].innerHTML), parseFloat(longitudes[i].innerHTML)]);
        }
        var aveLat = sumLats / positionLength;
        var aveLong = sumLongs / positionLength;

        setupMap(aveLat, aveLong, latLongDoubleValueArray);

    }


    //Sets up map related things.
    function setupMap(lat, long, array) {

        // Adds map view
        map = L.map('map').setView([lat, long], 13);
        L.control.zoom({
            position:'topright'
        })

        //Sets icon image and size.
        var orangeIcon = L.icon ({
            iconUrl: "images/orangeSquareMarker.png",
            iconSize: [3, 4],
            iconAnchor:  [2, 3],
            popupAnchor: [1, 1]
        })

        //I think this creates the actual map. Nothing shows without it.
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);

        // marker
        for (let i = 0; i < array.length; i++) {
            L.marker([array[i][0], array[i][1]], {icon:orangeIcon}).addTo(map);
        }
        //Add Start and finish marker
        //Also, separately, add option to crop parts of the run (Change start and end location).
    }

    //setup function. Called on page load.
    pub.setup = function () {

        document.getElementById('fileToUpload').addEventListener('change',interpretFile,false);

        if (document.getElementById("displayData")){

            var fileUploaded = window.sessionStorage.getItem('fileUploaded');
            getLatLongs(fileUploaded);

        }



    };

    return pub;
}());


//on page load, call setup.
if (document.getElementById) {
    window.onload = Map.setup;

}

