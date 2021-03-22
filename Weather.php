<?php
require 'vendor/autoload.php';

class Weather
{
    protected string $amusementUrl = "https://api.musement.com/";
    protected string $weatherUrl = "http://api.weatherapi.com/";
    protected string $apiKey = "f08324323fc142a294c182054211803";

    /**
     * Get cities from api.musement
     * @param string $id
     * @param array $params
     * @return false|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCities($id = "", $params = []) {
        try {
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', $this->amusementUrl . "api/v3/cities/$id", $params);
            return $res->getBody();
        }
        catch (Exception $ex) {
            echo "<p><strong>".$ex->getCode()."</strong> - ".$ex->getMessage()."</p>";
            return false;
        }
    }

    /**
     * Get city weather from api.weatherapi
     * @param $lat
     * @param $lng
     * @param array $params
     * @return false|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCityWeather($lat, $lng, $params = []){
        try {
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', $this->weatherUrl . "v1/forecast.json?key=". $this->apiKey."&q=$lat,$lng&days=2", $params);
            return $res->getBody();
        }
        catch (Exception $ex) {
            echo "<p><strong>".$ex->getCode()."</strong> - ".$ex->getMessage()."</p>";
            return false;
        }
    }
}