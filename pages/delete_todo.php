<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

// Check if list_id is provided via POST parameter
if (isset($_POST['list_id'])) {
    $list_id = $_POST['list_id'];

    // Delete todo list and associated items
    $stmt_delete_items = $conn->prepare("DELETE FROM todo_items WHERE list_id = :list_id");
    $stmt_delete_items->bindParam(':list_id', $list_id);
    $stmt_delete_items->execute();

    $stmt_delete_list = $conn->prepare("DELETE FROM todo_lists WHERE list_id = :list_id");
    $stmt_delete_list->bindParam(':list_id', $list_id);

    if ($stmt_delete_list->execute()) {
        // Redirect to index.php after successful deletion
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error deleting todo list.";
    }
} else {
    die("List ID parameter is missing.");
}
?>
