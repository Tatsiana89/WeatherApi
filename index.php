<?php

require_once("Weather.php");
require_once ("City.php");

$request = new Weather();
amusement($request);

function amusement(Weather $request) {
    $response = $request->getCities();
    if($response !== false) {
        $results = \GuzzleHttp\json_decode($response, true);
        if(!empty($results)) {
            foreach ($results as $res) {
                $city =  new City($res["id"], $res["name"], $res["latitude"], $res["longitude"]);
                outputWeather($city, $request);
            }
        }
        else echo "Empty result on api.";
    }
}

function outputWeather(City $city, Weather $request) {
    $response = $request->getCityWeather($city->getLatitude(), $city->getLongitude());
    if($response !== false) {
        $results = \GuzzleHttp\json_decode($response, true);
        if(!empty($results)) {
            $forecast = $results['forecast']['forecastday'];
            $dayOne = $forecast[0];
            $weatherOne = $dayOne["day"]["condition"]["text"];
            $dayTwo = $forecast[1];
            $weatherTwo = $dayTwo["day"]["condition"]["text"];
            $city->setWeatherOneDay($weatherOne);
            $city->setWeatherTwoDay($weatherTwo);
            echo "Processed city ".$city->getName()." | $weatherOne - $weatherTwo <br>";
        }
        else {
            echo "Empty result on api";
        }
    }
}