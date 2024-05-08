<?php
// Define database connection parameters
$host = 'todo-db.csrwfecdxdew.ap-southeast-1.rds.amazonaws.com';
$dbname = 'todo_database';
$username = 'app_admin';
$password = 'lNZ0LN0Zuz019PMDj3jk';

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions for errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionally, set other PDO attributes (e.g., character set)
    // $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle database connection error
    die("Connection failed: " . $e->getMessage());
}
?>
