<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: pages/login.php");
    exit();
}

include 'includes/db.php';

// Fetch user's todo lists
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM todo_lists WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$todo_lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <?php if (empty($todo_lists)) : ?>
            <p>No todo lists found. <a href="pages/create_todo.php" class="btn">Create a new todo list</a></p>
        <?php else : ?>
            <h2>Your Todo Lists:</h2>
            <ul>
                <?php foreach ($todo_lists as $list) : ?>
                    <li><a href="pages/view_todo.php?list_id=<?php echo $list['list_id']; ?>"><?php echo $list['title']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="pages/logout.php" class="btn">Logout</a>
    </div>
</body>
</html>