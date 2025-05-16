<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['board_id'], $_POST['board_name'])) {
    $id = $_POST['board_id'];
    $name = trim($_POST['board_name']);

    $stmt = $conn->prepare("UPDATE boards SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
