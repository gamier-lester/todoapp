<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $list_id = $_POST['list_id'];
    $description = $_POST['description'];

    $stmt_new_item = $conn->prepare("INSERT INTO todo_items (list_id, description) VALUES (:list_id, :description)");
    $stmt_new_item->bindParam(':list_id', $list_id);
    $stmt_new_item->bindParam(':description', $description);

    if ($stmt_new_item->execute()) {
        // Redirect back to view_todo.php after item creation
        header("Location: view_todo.php?list_id=$list_id");
        exit();
    } else {
        echo "Error creating new todo item.";
    }
} else {
    die("Invalid request.");
}
?>
