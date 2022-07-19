<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Event.php';

$db = new Database();
$conn = $db->connect();

$event = new Event($conn);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$event->name = $data->name;
$event->country = $data->country;
$event->city = $data->city;
$event->address = $data->address;
$event->date = $data->date;
$event->description = $data->description;
$event->cant = $data->cant;
$event->image_url = $data->image_url;


// Create event
echo json_encode(
    array('message' => $event->create())
);