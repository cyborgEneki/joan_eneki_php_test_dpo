<?php
// In a real setup, the environment variables would not be in plain text.
// Instead they would be loaded from a .env file with the help of a Composer package like vlucas/phpdotenv.

$serverName = "joaneneki-dpo-test.database.windows.net";
$databaseName = "test-db";
$uid = "dpo-admin";
$pwd = "QA3Z3ajJb77wW2r";

try {
    $conn = new PDO("sqlsrv:server = $serverName; Database = $databaseName;", $uid, $pwd);

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
