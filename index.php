<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

function getRequest($client, $sub_url, $json) {

    $res = $client->get($sub_url,
    [
        'json' => $json
    ]);

    if ($res->getStatusCode() < 200 || $res->getStatusCode() >= 300) {
        echo 'Error ! ';
        echo $res->getStatusCode();
        return null;
    } else {
        echo 'Success ! ';
        $response_body = $res->getBody();
        $response_body = json_decode($response_body, true);
        print_r($response_body);
        return $response_body;
    }
}

function postRequest($client, $sub_url, $json) {

    $res = $client->post($sub_url,
    [
        'json' => $json
    ]);

    if ($res->getStatusCode() < 200 || $res->getStatusCode() >= 300) {
        echo 'Error ! ';
        echo $res->getStatusCode();
    } else {
        echo 'Success ! ';
        $response_body = $res->getBody();
        $response_body = json_decode($response_body, true);
        print_r($response_body);
    }
}

function makePositionReading($client, $longitude, $latitude, $date, $id_container) {
    /* Add position */
    $owner = [
        '$class' => 'org.magma.max.PositionReading',
        'longitude' =>  $longitude,
        'latitude' =>  $latitude,
        'date' =>  $date,
        'container' => 'resource:org.magma.max.Container#'.$id_container,
    ];
    $sub_url_owner='org.magma.max.PositionReading' ;
    postRequest($client, $sub_url_owner, $owner);
}

function test() {
    $client = new Client(['base_uri' => 'http://ec2-34-247-38-3.eu-west-1.compute.amazonaws.com:3000/api/']);

    /* Create a owner */
    $owner = [
        '$class' => 'org.magma.max.Owner',
        'id' => 'owner15@gmail.com',
        'address' => [
            '$class' => 'org.magma.max.Address',
            'city' => 'Paris',
            'country' => 'France',
            'street' => 'Street',
            'zip' => '75001'
        ]
    ];
    $sub_url_owner='org.magma.max.Owner' ;
    postRequest($client, $sub_url_owner, $owner);

    /* Create a responsible */
    $responsible = [
        '$class' => 'org.magma.max.Responsible',
        'id' => 'responsible15@gmail.com',
        'address' => [
            '$class' => 'org.magma.max.Address',
            'city' => 'London',
            'country' => 'UK',
            'street' => 'Street'
        ]
    ];
    $sub_url_resp='org.magma.max.Responsible' ;
    postRequest($client, $sub_url_resp, $responsible);

    /* Create a site */
    $site = [
        '$class' => 'org.magma.max.Site',
        'identifier' => 'site15@gmail.com',
        'longitude' =>  3.0862800,
        'latitude' =>  45.7796600,
        'geofence' =>  100,
        'type' => 'FACTORY',
        'business' => 'resource:org.magma.max.Responsible#responsible15@gmail.com',
        'address' => [
            '$class' => 'org.magma.max.Address',
            'city' => 'Clermont-Ferrand',
            'country' => 'France',
            'street' => 'Street'
        ]
    ];
    $sub_url_site='org.magma.max.Site';
    postRequest($client, $sub_url_site, $site);

    /* Create a container */
    $container = [
        '$class' => 'org.magma.max.Container',
        'containerId' => 'CONT_001',
        'status' => 'IN_SITE',
        'site' => 'resource:org.magma.max.Site#site15@gmail.com',
        'owner' => 'resource:org.magma.max.Owner#owner15@gmail.com',
    ];
    $sub_url_container='org.magma.max.Container';
    postRequest($client, $sub_url_container, $container);

    makePositionReading($client, 3.0862800, 45.7796600, 100000, 'CONT_001');
}

?>
