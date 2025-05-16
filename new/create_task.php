<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $list_id = intval($_POST['list_id']);
    $title = $conn->real_escape_string($_POST['title']);

    $conn->query("INSERT INTO tasks (list_id, title) VALUES ($list_id, '$title')");

    // Redirect back to board
    $board_id = $conn->query("SELECT board_id FROM task_lists WHERE id = $list_id")->fetch_assoc()['board_id'];
    header("Location: board.php?id=$board_id");
}
