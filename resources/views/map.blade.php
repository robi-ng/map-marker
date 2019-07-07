<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Map Marker</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                padding: 0 20px;
            }
            #map {
                height: 80%;
                width: 70%;
            }
            select {
                margin-bottom: 10px;
            }
            .red {
                color: #FF0000;
            }
        </style>
    </head>
    <body>
        <h2>Map Marker</h2>
        <select id="filter" onchange="initMap()">
            <option value="1">Last 1 hour</option>
            <option value="4">Last 4 hours</option>
            <option value="12">Last 12 hours</option>
            <option value="24" selected>Last 24 hours</option>
        </select>
        <div id="errorMessage" class="red"></div>
        <div id="map"></div>
        <script>
            var map;
            var coordinateList = [];
            var markerList = [];
            function initMap() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showAllPositionsOnMap);
                } else {
                    document.getElementById('errorMessage').innerHTML = "Geolocation is not supported by this browser.";
                }
            }
            function showAllPositionsOnMap(position) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        var currentPosition = {lat: position.coords.latitude, lng: position.coords.longitude};
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: currentPosition,
                            zoom: 2
                        });
                        coordinateList = JSON.parse(xhr.response);
                        coordinateList.push({latitude: position.coords.latitude, longitude: position.coords.longitude});
                        coordinateList.forEach(function(coordinate) {
                            addMarker(coordinate);
                        });
                        storeCoordinate(position);
                    } else {
                        document.getElementById('errorMessage').innerHTML = "API request failed!";
                    }
                };
                xhr.open('GET', '/coordinates?filter=' + document.getElementById('filter').value);
                xhr.send();
            }
            function addMarker(coordinate) {
                var marker = new google.maps.Marker({
                    position: {lat: coordinate.latitude, lng: coordinate.longitude},
                    map: map
                });
                markerList.push(marker);
            }
            function storeCoordinate(position) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function () {
                    if (xhr.status == 200) {
                    } else {
                        document.getElementById('errorMessage').innerHTML = "API request failed!";
                    }
                };
                xhr.open('POST', '/coordinates');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{csrf_token()}}');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
                xhr.send('latitude=' + position.coords.latitude + '&longitude=' + position.coords.longitude);
            }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('app.google_map_api_key') }}&callback=initMap">
        </script>
    </body>
</html>
