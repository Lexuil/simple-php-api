<?php

// Check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once 'create.php';
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include_once 'get.php';
}