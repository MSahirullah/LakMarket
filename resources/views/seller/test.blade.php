<!DOCTYPE html>
<html>

<head>
    <title>Simple Map</title>

    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <!-- <script>
        let map;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: -34.397,
                    lng: 150.644
                },
                zoom: 8,
            });
        }
    </script> -->
</head>

<body>
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script>
        var marker = false; ////Has the user plotted their location marker? 
        function initMap() {
            var lo = 6.936144491868273;
            var la = 79.90254512705042;
            var centerOfMap = new google.maps.LatLng(lo, la);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: centerOfMap,
                //scrollwheel: false,
                zoom: 12
            });

            var _marker = new google.maps.Marker({
                position: centerOfMap,
                map: map,
                title: 'Hello World!'
            });

            _marker.setMap(map);

            //Listen for any clicks on the map.
            google.maps.event.addListener(map, 'click', function(event) {
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                //If the marker hasn't been added.
                if (marker === false) {
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function(event) {
                        markerLocation();
                    });
                } else {
                    //Marker has already been added, so just change its location.
                    marker.setPosition(clickedLocation);
                }
                //Get the marker's location.
                markerLocation();
            });

        } // close function here

        //This function will get the marker's current location and then add the lat/long
        //values to our textfields so that we can save the location.
        function markerLocation() {
            //Get location.
            var currentLocation = marker.getPosition();
            //Add lat and lng values to a field that we can save.
            console.log(currentLocation.lat());
            console.log(currentLocation.lng());
        }
    </script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQxriVKFmURanWzX7-k-WG1gdN30drD4&callback=initMap&libraries=&v=weekly" async></script>

</body>

</html>