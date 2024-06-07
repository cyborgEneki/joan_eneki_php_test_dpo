<?php
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

    $stmt = $conn->query($sql);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $json = json_encode($results);

    if ($json === false) {
        throw new Exception("Error: Unable to encode results as JSON.");
    }

    header('Content-Type: application/json');

    echo $json . PHP_EOL;
} catch (PDOException $e) {
    echo "<h1>Caught PDO exception:</h1>";
    echo $e->getMessage() . PHP_EOL;
}
