<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'todo-db.csrwfecdxdew.ap-southeast-1.rds.amazonaws.com';
$dbname = 'todo_database';
$username = 'app_admin';
$password = 'lNZ0LN0Zuz019PMDj3jk';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['username'];
    $pword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $uname);
    $stmt->bindParam(':password', $pword);

    if (empty($uname) || empty($pword)) {
        header("Location: failed.php");
        exit;
    }

    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: success.php");
        exit;
    } else {
        // Redirect to failed page
        header("Location: failed.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="register.php">
            <div class="input-group">
                <label for="new_username">Choose Username:</label>
                <input type="text" id="new_username" name="username">
            </div>
            <div class="input-group">
                <label for="new_password">Choose Password:</label>
                <input type="password" id="new_password" name="password">
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
