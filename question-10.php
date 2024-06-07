<?php
$apiUrl = 'https://jsonplaceholder.typicode.com/users';

$response = file_get_contents($apiUrl);

if ($response === false) {
    echo "Error: Data fetching failed.";
    exit;
}

$users = json_decode($response, true);

if ($users === null) {
    echo "Error: Not able to parse JSON." . PHP_EOL;
    exit;
}


foreach ($users as $user) {
    echo "Name: {$user['name']}, Email: {$user['email']}" . PHP_EOL;
}
