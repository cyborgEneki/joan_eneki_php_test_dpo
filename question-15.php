<?php
require 'vendor/autoload.php'; 

// *** SECURITY MEASURE 1: Environment variables should not be passed to the script in plain text. ***
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$serverName = $_ENV['DB_SERVER_NAME'];
$databaseName = $_ENV['DB_DATABASE_NAME'];
$userName = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

try {
    $conn = new PDO("sqlsrv:server = $serverName; Database = $databaseName;", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        SELECT 
            c.customer_id, 
            c.name, 
            c.email, 
            SUM(oi.quantity * oi.price) AS total_sales, 
            SUM(oi.quantity) AS total_items
        FROM 
            customers c
        INNER JOIN 
            orders o ON c.customer_id = o.customer_id
        INNER JOIN 
            order_items oi ON o.order_id = oi.order_id
        GROUP BY 
            c.customer_id, c.name, c.email
    ";

    // *** SECURITY MEASURE 2: Use of prepared statements to prevent SQL injection. ***
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // *** SECURITY MEASURE 3: Sanitize output to prevent XSS attacks. ***
    array_walk_recursive($results, function (&$item) {
        $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
    });

    $json = json_encode($results);

    if ($json === false) {
        throw new Exception("Error: Unable to encode results as JSON.");
    }

    header('Content-Type: application/json');

    echo $json . PHP_EOL;
} catch (PDOException $e) {
    error_log($e->getMessage());

    // *** SECURITY MEASURE 4: Display a generic error message to the user. While logging is necessary, detailed error messages must not displayed to the end-user. ***
    echo "An error occurred while processing your request. Please try again later." . PHP_EOL;
}
