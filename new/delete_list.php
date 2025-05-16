<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

if (isset($_GET['id'])) {
    $list_id = (int) $_GET['id'];

    // Delete the tasks under the list first (to prevent foreign key constraint issues)
    $conn->query("DELETE FROM tasks WHERE list_id = $list_id");

    // Then delete the list itself
    $conn->query("DELETE FROM task_lists WHERE id = $list_id");

    // Redirect back to board.php
    // You need the board_id to redirect back correctly!
    $board_id_result = $conn->query("SELECT board_id FROM task_lists WHERE id = $list_id");
    if ($board_id_result && $board_id_result->num_rows > 0) {
        $row = $board_id_result->fetch_assoc();
        $board_id = $row['board_id'];
    } else {
        // fallback if already deleted
        $board_id = $_GET['board_id'] ?? 0;
    }

    header("Location: board.php?id=$board_id");
    exit;
} else {
    echo "No list ID provided.";
}
?>
