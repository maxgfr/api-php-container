<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

function addParticipant($client, $sub_url, $json) {

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

function getParticipant($client, $sub_url, $json) {

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

function init () {
    $client = new Client(['base_uri' => 'http://ec2-34-247-38-3.eu-west-1.compute.amazonaws.com:3000/api/']);

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
    addParticipant($client, $sub_url_owner, $owner);

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
    addParticipant($client, $sub_url_resp, $responsible);
}

$client = new Client(['base_uri' => 'http://ec2-34-247-38-3.eu-west-1.compute.amazonaws.com:3000/api/']);

$responsibleuh = [
    'id' => 'responsible15@gmail.com',
];
$sub_url_responsibleuh='org.magma.max.Responsible' ;
$resp = getParticipant($client, $sub_url_responsibleuh, $responsibleuh);
$site = [
    '$class' => 'org.magma.max.Site',
    'identifier' => 'site15@gmail.com',
    'longitude' =>  3.0862800,
    'latitude' =>  45.7796600,
    'geofence' =>  100,
    'type' => 'org.magma.max.Type.FACTORY',
    'address' => [
        '$class' => 'org.magma.max.Address',
        'city' => 'Clermont-Ferrand',
        'country' => 'France',
        'street' => 'Street'
    ],
    'business' => [
        '$class' => 'org.magma.max.Responsible',
        'id' => 'responsible15@gmail.com',
        'address' => [
            '$class' => 'org.magma.max.Address',
            'city' => 'London',
            'country' => 'UK',
            'street' => 'Street'
        ]
    ]
];
$sub_url_site='org.magma.max.Site';
addParticipant($client, $sub_url_site, $site);


?>
