<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

function addOwner($client, $id) {

    $res = $client->post('org.magma.max.Owner' ,
    [
        'json' =>
        [
            '$class' => 'org.magma.max.Owner',
            'id' => $id,
            'address' => [
                '$class' => 'org.magma.max.Address',
                'city' => 'Paris',
                'country' => 'France',
                'street' => 'Street',
                'zip' => '75001'
            ]
        ]
    ]);

    if ($res->getStatusCode() < 200 || $res->getStatusCode() >= 300) {
        echo 'Error\n';
        echo $res->getStatusCode();
    } else {
        echo 'Success\n';
        $response_body = $res->getBody();
        $response_body = json_decode($response_body, true);
        print_r($response_body);
    }
}

$client = new Client(['base_uri' => 'http://ec2-34-247-38-3.eu-west-1.compute.amazonaws.com:3000/api/']);
addOwner($client, 'owner10@gmail.com');



?>
