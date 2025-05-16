<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

$task_id = $_GET['id'] ?? 0;
$task = $conn->query("SELECT * FROM tasks WHERE id = $task_id")->fetch_assoc();
$conn->query("DELETE FROM tasks WHERE id = $task_id");

header("Location: board.php?id=" . $task['board_id']);
exit;
