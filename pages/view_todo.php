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

if (isset($_GET['list_id'])) {
    $list_id = $_GET['list_id'];

    // Fetch todo list details
    $stmt = $conn->prepare("SELECT * FROM todo_lists WHERE list_id = :list_id");
    $stmt->bindParam(':list_id', $list_id);
    $stmt->execute();
    $todo_list = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$todo_list) {
        die("Todo list not found.");
    }

    // Fetch todo items for the list
    $stmt_items = $conn->prepare("SELECT * FROM todo_items WHERE list_id = :list_id");
    $stmt_items->bindParam(':list_id', $list_id);
    $stmt_items->execute();
    $todo_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

    // Handle form submission to create new todo item
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    }
} else {
    die("List ID parameter is missing.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Details</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="todo-list-container">
        <h1>Todo List: <?php echo htmlspecialchars($todo_list['title']); ?></h1>

        <ul class="todo-list">
            <?php foreach ($todo_items as $item) : ?>
                <li><?php echo htmlspecialchars($item['description']); ?></li>
            <?php endforeach; ?>
        </ul>

        <!-- Form to create new todo item -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?list_id=' . $list_id; ?>" class="todo-form">
            <div class="form-group">
                <label for="description">New Todo Item:</label>
                <input type="text" id="description" name="description" required>
            </div>
            <button type="submit" class="btn" style="min-width: 80%">Add Item</button>
        </form>

        <!-- Edit Todo List and Delete Todo List buttons -->
        <a href="confirm_delete.php?list_id=<?php echo $list_id; ?>" class="btn">Delete Todo List</a>
        <a href="../index.php" class="btn">Back to Home</a>
    </div>
</body>
</html>
