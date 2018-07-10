<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://ec2-34-247-38-3.eu-west-1.compute.amazonaws.com:3000/api/']);

$headers = [
    'Content-type' => 'application/json; charset=utf-8',
    'Accept' => 'application/json',
];

$res = $client->post('/org.magma.max.Owner', $headers , [
    'json' =>
    [
        '$class' => 'org.magma.max.Owner',
        'id' => 'owner@gmail.com',
        'address' => [
            '$class' => 'org.magma.max.Address',
            'city' => 'Paris',
            'country' => 'France',
            'street' => 'Street',
            'zip' => '75001',
            'id' => '1',
        ]
    ]
]);

if ($res->getStatusCode() < 200 || $res->getStatusCode() >= 300) {
    print_r('Error');
    print_r($res->getStatusCode());
} else {
    $response_body = $res->getBody();
    $response_body = json_decode($response_body, true);
    print_r($response_body);
}


?>
