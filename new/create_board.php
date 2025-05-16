<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['board_name'])) {
    $name = $conn->real_escape_string($_POST['board_name']);
    $conn->query("INSERT INTO boards (name) VALUES ('$name')");
}

header("Location: dashboard.php");
exit;