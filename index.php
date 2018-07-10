<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;


$client = new Client(['base_uri' => 'http://ec2-34-247-38-3.eu-west-1.compute.amazonaws.com:3000/api/']);

$post_data = array(
    '$class' => 'org.magma.max.Owner',
    'id' => '1',
    'address' => array(
        '$class' => 'org.magma.max.Address',
        'city' => 'Paris',
        'country' => 'France',
        'street' => 'Street',
        'zip' => '75001',
        'id' => '1',
    );
);


$res = $client->post('org.magma.max.Owner', array(
    'query' => $post_data
));

$response_body = $res->getBody();
$response_body = json_decode($response_body, true);
print_r($response_body);
?>




const factory = getFactory();
const NS = 'org.magma.max';

// create the owner
const owner = factory.newResource(NS, 'Owner', 'owner@email.com');
const ownerAddress = factory.newConcept(NS, 'Address');
ownerAddress.country = 'France';
owner.address = ownerAddress;

// create the responsible
const responsible = factory.newResource(NS, 'Responsible', 'responsible@email.com');
const responsibleAddress = factory.newConcept(NS, 'Address');
responsibleAddress.country = 'UK';
responsible.address = responsibleAddress;

// create the site
const site = factory.newResource(NS, 'Site', 'site@email.com');
const siteAddress = factory.newConcept(NS, 'Address');
siteAddress.country = 'Clermont-Ferrand';
site.address = siteAddress;
site.longitude = 3.0862800;
site.latitude = 45.7796600;
site.geofence = 100;
site.type = 'FACTORY';
site.business = factory.newRelationship(NS, 'Responsible', 'business@email.com');

// create the container
const container = factory.newResource(NS, 'Container', 'CONT_001');
container.status = 'IN_SITE';
container.owner = factory.newRelationship(NS, 'Owner', 'owner@email.com');
container.site = factory.newRelationship(NS, 'Site', 'site@email.com');

// add the owners
const ownerRegistry = await getParticipantRegistry(NS + '.Owner');
await ownerRegistry.addAll([owner]);

// add the responsibles
const responsibleRegistry = await getParticipantRegistry(NS + '.Responsible');
await responsibleRegistry.addAll([responsible]);

// add the sites
const siteRegistry = await getParticipantRegistry(NS + '.Site');
await siteRegistry.addAll([site]);

// add the containers
const containerRegistry = await getAssetRegistry(NS + '.Container');
await containerRegistry.addAll([container]);
