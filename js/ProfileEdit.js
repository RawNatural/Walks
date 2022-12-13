
var ProfileEdit = (function () {
    "use strict";

    var pub = {};

    function switchDisabled() {
        alert("switch dis");
    }

    //setup function. Called on page load.
    pub.setup = function () {

        document.getElementById("editButton").addEventListener("click", function() {
            var input = document.getElementsByClassName("editProfileInput");
            //input.forEach(switchDisabled);
            for (let i = 0; i < input.length; i++) {
                input[i].removeAttribute("disabled");
                console.log(input[i]);
            }
            document.getElementById("editProfileFieldset").style.opacity = "100%";

            document.getElementById("editProfileButton").removeAttribute("disabled");

        });
    };

    return pub;

}());


//on page load, call setup.
if (document.getElementById) {
    window.onload = ProfileEdit.setup;

}
