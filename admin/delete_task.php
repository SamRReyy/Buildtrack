<?php
// delete_task.php

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

// Get project ID before deleting
$stmt = $connection->prepare("SELECT project_id FROM tasks WHERE id = ?");
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    echo "Task not found.";
    exit;
}

$project_id = $task['project_id'];

// Delete task
$stmt = $connection->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->bind_param("i", $task_id);
$stmt->execute();

header("Location: project_tasks.php?id=$project_id");
exit;
