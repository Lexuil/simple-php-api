<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Event.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate event object
$event = new Event($db);

// Get events
$result = $event->all();

// Check if any events
if($result->rowCount() > 0) {
    $event_arr = array();
    $event_arr['events'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $event_item = array(
            'id' => $id,
            'name' => $name,
            'country' => $country,
            'city' => $city,
            'address' => $address,
            'date' => $date,
            'description' => $description,
            'cant' => $cant,
            'image_url' => $image_url,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );
        // Push to "data"
        $event_arr['events'][] = $event_item;
    }
    // Turn to JSON & output
    echo json_encode($event_arr);
} else {
    // No events
    echo json_encode(
        array('message' => 'No Events Found')
    );
}