<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform logout actions
    session_unset();
    session_destroy();
    header("Location: login.php"); // Redirect to login page after logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Are you sure you want to logout?</h2>
        <form method="post">
            <button type="submit" class="btn" style="min-width: 80%">Logout</button>
        </form>
        <a href="index.php" class="btn">Cancel</a>
    </div>
</body>
</html>
