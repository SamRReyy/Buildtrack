<?php
// add_task.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$project_id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $task_name = trim($_POST['task_name']);

        if (!empty($task_name)) {
            $stmt = $connection ->prepare("INSERT INTO tasks (project_id, task_name) VALUES (?, ?)");
            $stmt->bind_param("is", $project_id, $task_name);
            $stmt->execute();

            // Redirect back to project.php with the project ID
            header("Location: project.php");
            exit;
        } else {
            $error = "Task name cannot be empty.";
        }
    } elseif (isset($_POST['cancel'])) {
        error_log("Cancel button clicked."); // Log to PHP error log
        header("Location: project.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Add Task</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name:</label>
            <input type="text" name="task_name" id="task_name" class="form-control" required>
        </div>
        <button type="submit" name="confirm" class="btn btn-success">Confirm</button>
        <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
    </form>

</body>
</html>
