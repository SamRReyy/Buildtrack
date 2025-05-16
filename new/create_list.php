<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $board_id = intval($_POST['board_id']);
    $name = $conn->real_escape_string($_POST['list_name']);

    $conn->query("INSERT INTO task_lists (board_id, name) VALUES ($board_id, '$name')");
    header("Location: board.php?id=$board_id");
}
