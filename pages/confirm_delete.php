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

// Check if list_id is provided via GET parameter
if (isset($_GET['list_id'])) {
    $list_id = $_GET['list_id'];
} else {
    die("List ID parameter is missing.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Todo List Confirmation</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="confirmation-container">
        <h1>Delete Todo List Confirmation</h1>
        <p>Are you sure you want to delete this todo list?</p>

        <form method="POST" action="delete_todo.php">
            <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
            <button type="submit" class="btn">Confirm Delete</button>
            <a href="view_todo.php?list_id=<?php echo $list_id; ?>" class="btn">Cancel</a>
        </form>
    </div>
</body>
</html>
