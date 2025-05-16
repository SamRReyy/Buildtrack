<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['board_id'])) {
    $id = $_POST['board_id'];

    // Optional: delete related task lists and tasks first
    $conn->query("DELETE FROM tasks WHERE list_id IN (SELECT id FROM task_lists WHERE board_id = $id)");
    $conn->query("DELETE FROM task_lists WHERE board_id = $id");

    $stmt = $conn->prepare("DELETE FROM boards WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
