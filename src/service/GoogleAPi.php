<?php

/*API DE GOOGLE PLATFORM GEOLOCATE
          Je vais récupérer la longitude et la lagitude du visiteur
          */
$url = 'https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyBCcvetQ6xUYPOC8UNmbNKjHNI9CBbBX1w';
$ch =curl_init($url);
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
$test = json_decode(curl_exec($ch),true);

/*API DE GOOGLE PLATFORM GEOCODING
Je traduis cette longitude et lagitude en données lisibles, tels que le pays,le code postal etc....
*/
$url2 = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.
$test['location']['lat'].','.$test['location']['lng'].'&key=AIzaSyBCcvetQ6xUYPOC8UNmbNKjHNI9CBbBX1w';
$test2 = json_decode(file_get_contents($url2),true);