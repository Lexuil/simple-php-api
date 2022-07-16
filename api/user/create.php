<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->identification = $data->identification;
$user->email = $data->email;
$user->phone = $data->phone;
$user->birthday = $data->birthday;
$user->password = $data->password;

// Create user
echo json_encode(
    array('message' => $user->create())
);