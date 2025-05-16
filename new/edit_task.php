<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

$task_id = $_GET['id'] ?? 0;
$task = $conn->query("
    SELECT tasks.*, task_lists.board_id 
    FROM tasks 
    JOIN task_lists ON tasks.list_id = task_lists.id 
    WHERE tasks.id = $task_id
")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $due_date = $_POST['due_date'];
    $start_date = $_POST['start_date'];
    $assigned_user = $_POST['assigned_user'];
    $location = $_POST['location'];
    $label = $_POST['label'] ?? '';  // This line can also be removed if no longer needed.
    $due_date_reminder = $_POST['due_date_reminder'];

    // Update task with additional data
    $conn->query("
        UPDATE tasks 
        SET title = '$title', due_date = '$due_date', start_date = '$start_date', 
            assigned_user = '$assigned_user', location = '$location', label = '$label', 
            due_date_reminder = '$due_date_reminder' 
        WHERE id = $task_id
    ");

    header("Location: board.php?id=" . $task['board_id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Custom Styling */
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #495057;
        }

        .form-control, .form-select {
            border-radius: 10px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .btn-outline-secondary {
            border-radius: 10px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            border-radius: 10px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f1f1;
        }

        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body class="py-5">

    <div class="container">
        <h3><i class="fas fa-edit"></i> Edit Task</h3>

        <!-- Back to board button -->
        <a href="board.php?id=<?= $task['board_id'] ?>" class="btn btn-outline-secondary btn-back">
            <i class="fas fa-arrow-left me-1"></i> Back to Board
        </a>

        <form method="POST" class="mt-4" onsubmit="return confirmSubmit()">
            <!-- Task Title -->
            <div class="mb-3">
                <label class="form-label">Task Title</label>
                <input type="text" name="title" class="form-control" value="<?=($task['title']) ?>" required>
            </div>

            <!-- Due Date -->
            <div class="mb-3">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" value="<?= $task['due_date'] ?>">
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?= $task['start_date'] ?>">
            </div>

            <!-- Assigned User -->
            <div class="mb-3">
                <label class="form-label">Assigned User</label>
                <input type="text" name="assigned_user" class="form-control" value="<?= ($task['assigned_user']) ?>">
            </div>

            <!-- Location -->
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="<?= ($task['location']) ?>">
            </div>

            <!-- Due Date Reminder -->
            <div class="mb-3">
                <label class="form-label">Due Date Reminder</label>
                <input type="datetime-local" name="due_date_reminder" class="form-control" value="<?= $task['due_date_reminder'] ?>">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success w-100"><i class="fas fa-save"></i> Update Task</button>
        </form>
    </div>

    <!-- JS for form confirmation -->
    <script>
        function confirmSubmit() {
            return confirm("Are you sure you want to update this task?");
        }
    </script>

</body>
</html>
