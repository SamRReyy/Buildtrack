<?php
// task_list.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$task_id = intval($_GET['id']);

// Fetch task data
$stmt = $connection->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    echo "Task not found.";
    exit;
}

// Calculate the difference between the current date and the due date
$current_date = new DateTime();
$due_date = new DateTime($task['due_date']);
$interval = $current_date->diff($due_date);

// Determine the color based on the number of days remaining
$due_date_color = '';
if ($interval->invert == 1) {
    // If the due date has passed
    $due_date_color = 'text-danger'; // Red for overdue
} elseif ($interval->days <= 3) {
    // If the due date is within 3 days
    $due_date_color = 'text-warning'; // Yellow for near due
} else {
    // If the due date is far away
    $due_date_color = 'text-success'; // Green for safe
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $works = $_POST['works'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $due_date = $_POST['due_date'];
    $personnel = $_POST['personnel'];
    $location = $_POST['location'];

    $stmt = $connection->prepare("UPDATE tasks SET task_name=?, works=?, start_date=?, end_date=?, due_date=?, personnel=?, location=? WHERE id=?");
    $stmt->bind_param("sssssssi", $task_name, $works, $start_date, $end_date, $due_date, $personnel, $location, $task_id);
    $stmt->execute();

    $success = "Task updated successfully.";
    // Redirect back to the project tasks page
    header("Location: project_tasks.php?id=" . $task['project_id']);
    header("Location: project.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Edit Task</h2>

    <?php if (isset($success)) : ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Task Name:</label>
            <input type="text" name="task_name" class="form-control" value="<?= htmlspecialchars($task['task_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">List of Works:</label>
            <textarea name="works" class="form-control" rows="4"><?= htmlspecialchars($task['works']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="<?= $task['start_date'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">End Date:</label>
            <input type="date" name="end_date" class="form-control" value="<?= $task['end_date'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Due Date:</label>
            <input type="date" name="due_date" class="form-control <?= $due_date_color ?>" value="<?= $task['due_date'] ?>">
            <small class="<?= $due_date_color ?>">
                <?php
                if ($interval->invert == 1) {
                    echo "This task is overdue!";
                } elseif ($interval->days <= 3) {
                    echo "The due date is approaching in {$interval->days} day(s).";
                } else {
                    echo "The due date is in {$interval->days} day(s).";
                }
                ?>
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label">Personnel:</label>
            <input type="text" name="personnel" class="form-control" value="<?= htmlspecialchars($task['personnel']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Location:</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($task['location']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="project.php?id=<?= $task['project_id'] ?>" class="btn btn-secondary">Cancel</a>
    </form>

</body>
</html>
