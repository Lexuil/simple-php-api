<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate user object
$user = new User($db);

// Get users
$result = $user->all();

// Check if any users
if($result->rowCount() > 0) {
    $users_arr = array();
    $users_arr['users'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'identification' => $identification,
            'email' => $email,
            'phone' => $phone,
            'birthday' => $birthday,
            'password' => $password,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );
        // Push to "data"
        $users_arr['users'][] = $user_item;
    }
    // Turn to JSON & output
    echo json_encode($users_arr);
} else {
    // No users
    echo json_encode(
        array('message' => 'No Users Found')
    );
}