<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch task data (example query, adjust as needed)
$task_id = isset($_GET['task_id']) ? intval($_GET['task_id']) : null;
$task = null;

if ($task_id) {
    $stmt = $connection->prepare("SELECT id, is_complete FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
    $stmt->close();
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $is_complete = $_POST['is_complete'];

    // Update the task's completion status
    $stmt = $connection->prepare("UPDATE tasks SET is_complete = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_complete, $task_id);

    if ($stmt->execute()) {
        echo "Task status updated successfully.";
    } else {
        echo "Error updating task status: " . $connection->error;
    }

    $stmt->close();
}

$connection->close();
?>

<script>
function updateTaskStatus(taskId, isComplete) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_task_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Optional: Log the response for debugging
        }
    };
    xhr.send(`task_id=${taskId}&is_complete=${isComplete ? 1 : 0}`);
}






