<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$serverName = $_ENV['DB_SERVER_NAME'];
$databaseName = $_ENV['DB_DATABASE_NAME'];
$userName = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

try {
    $conn = new PDO("sqlsrv:server = $serverName; Database = $databaseName;", $userName, $password);

    $sql = "SELECT customer_id, name, email FROM customers";
    $stmt = $conn->query($sql);

    $customers = $stmt->fetchAll();

    foreach ($customers as $customer) {
        echo "Customer ID: " . $customer['customer_id'] . "\n";
        echo "Name: " . $customer['name'] . "\n";
        echo "Email: " . $customer['email'] . "\n";
        echo "--------------------------\n";
    }
} catch (PDOException $e) {
    echo "<h1>Caught PDO exception:</h1>";
    echo $e->getMessage() . PHP_EOL;
}
