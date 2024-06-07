<?php
$servername = "joaneneki-dpo-test";
$dbname = "test-db";
$username = "dpo-admin";
$password = "QA3Z3ajJb77wW2r";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set PDO attributes
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Execute queries and perform database operations
    // ...

    // Close the connection
    $conn = null;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
