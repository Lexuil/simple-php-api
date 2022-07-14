<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($db);

echo $user->create('John', 'Doe', 'jhon@gmail.com', '123456789', '1990-01-01', '123456');
echo $user->create('Jane', 'Doe', 'jane@gmail.com', '123456789', '1990-01-01', '123456');