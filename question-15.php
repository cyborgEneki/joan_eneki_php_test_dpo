<?php
// *** SECURITY MEASURE 1: Environment variables should not be passed to the script in plain text. ***

// In a real setup, they would be loaded from a .env file 
// This would be done with the help of a Composer package like vlucas/phpdotenv as follows:

// require 'vendor/autoload.php'; 
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// $serverName = getenv('DB_SERVER_NAME');
// $databaseName = getenv('DB_DATABASE_NAME');
// $uid = getenv('DB_USERNAME');
// $pwd = getenv('DB_PASSWORD');

$serverName = "joaneneki-dpo-test.database.windows.net";
$databaseName = "test-db";
$uid = "dpo-admin";
$pwd = "QA3Z3ajJb77wW2r";

try {
    $conn = new PDO("sqlsrv:server = $serverName; Database = $databaseName;", $uid, $pwd);
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
