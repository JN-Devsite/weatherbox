<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use \eftec\bladeone\BladeOne;
use Carbon\Carbon;

class Weather
{
    private $apiKey;
    private $resource;

    public function __construct()
    {
        $this->apiKey = 'met-office-api-key';
    }

    public function getWeather($city)
    {
        $guzzle = new Client();
        $this->resource = 'val/wxfcs/all/json/';

        $locations = [
            'Greenwich' => 351683,
            'Northampton' => 310054,
        ];

        $locationId = $locations[$city];

        $params = [
            'query' => [
                // 'res' => '3hourly',
                'res' => 'daily',
                'key' => $this->apiKey
            ]
        ];

        $url = 'http://datapoint.metoffice.gov.uk/public/data/' . $this->resource . '/' . $locationId;

        $response = $guzzle->request('GET', $url, $params);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody(), true);
        } else {
            $data = ['error' => $response->getReasonPhrase()]; 
        }

        // return json_encode($data, JSON_PRETTY_PRINT);
        return $data;
        
    }
}

$i = new Weather();
$location = 'Northampton';
$weather = $i->getWeather($location);
// header('Content-type: application/json; charset=utf-8');

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne();
$weatherType = [
    'Clear night',
    'Sunny day',
    'Partly cloudy (night)',
    'Partly cloudy (day)',
    'Not used',
    'Mist',
    'Fog',
    'Cloudy',
    'Overcast',
    'Light rain shower (night)',
    'Light rain shower (day)',
    'Drizzle',
    'Light rain',
    'Heavy rain shower (night)',
    'Heavy rain shower (day)',
    'Heavy rain',
    'Sleet shower (night)',
    'Sleet shower (day)',
    'Sleet',
    'Hail shower (night)',
    'Hail shower (day)',
    'Hail',
    'Light snow shower (night)',
    'Light snow shower (day)',
    'Light snow',
    'Heavy snow shower (night)',
    'Heavy snow shower (day)',
    'Heavy snow',
    'Thunder shower (night)',
    'Thunder shower (day)',
    'Thunder'
];
$visibility = [
    'UN' => 'Unknown',
    'VP' => 'Very poor - Less than 1 km',
    'PO' => 'Poor - Between 1-4 km',
    'MO' => 'Moderate - Between 4-10 km',
    'GO' => 'Good - Between 10-20 km',
    'VG' => 'Very good - Between 20-40 km',
    'EX' => 'Excellent - More than 40 km'
];
$legend = [];
foreach ($weather['SiteRep']['Wx']['Param'] as $value) {
    $key = $value['name'];
    $legend[$key] = ['name' => $value['$'], 'units' => $value['units']];
}

echo $blade->run(
    'weather',
    [
        'data' => $weather['SiteRep']['DV'],
        'legend' => $legend,
        'location' => $location,
        'weatherType' => $weatherType,
        'visibility' => $visibility
    ]
);
// echo $weather;
