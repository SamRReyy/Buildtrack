<?php
// project_tasks.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_GET['id'])) {
    echo "Project ID is missing.";
    exit;
}

$project_id = intval($_GET['id']);

// Fetch tasks for the project
$stmt = $connection->prepare("SELECT * FROM tasks WHERE project_id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Tasks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this task?")) {
                window.location.href = 'delete_task.php?id=' + id;
            }
        }
    </script>
</head>
<body class="container mt-4">

    <h2>Tasks for Project #<?= $project_id ?></h2>
    <a href="add_task.php?id=<?= $project_id ?>" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Add Task
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Task Name</th>
                <th>Personnel</th>
                <th>Location</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($task = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= htmlspecialchars($task['task_name']) ?></td>
                <td><?= htmlspecialchars($task['personnel']) ?></td>
                <td><?= htmlspecialchars($task['location']) ?></td>
                <td><?= $task['start_date'] ?></td>
                <td><?= $task['end_date'] ?></td>
                <td><?= $task['due_date'] ?></td>
                <td>
                    <a href="task_list.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                    <button onclick="confirmDelete(<?= $task['id'] ?>)" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
