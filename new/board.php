<?php
$conn = new mysqli("localhost", "root", "", "constructstore");

$board_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get board info
$board = $conn->query("SELECT * FROM boards WHERE id = $board_id")->fetch_assoc();

// Get lists for this board
$lists = $conn->query("SELECT * FROM task_lists WHERE board_id = $board_id ORDER BY position ASC");

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $task_id = intval($_POST['task_id']);
    $comment = $conn->real_escape_string($_POST['comment']);

    $stmt = $conn->prepare("INSERT INTO comments (task_id, comment) VALUES (?, ?)");
    $stmt->bind_param("is", $task_id, $comment);
    $stmt->execute();
    $stmt->close();

    header("Location: board.php?id=$board_id");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $board['name'] ?> - ConstructStore</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; }
        .container { max-width: 1200px; }
        h2 { color: #2c3e50; }
        .card { border-radius: 12px; margin-bottom: 20px; }
        .card-header { background-color: #007bff; color: white; font-weight: bold; border-radius: 12px 12px 0 0; }
        .card-body { background-color: #ffffff; padding: 20px; }
        .card-footer { background-color: #f8f9fa; }
        .btn-outline-secondary, .btn-success, .btn-secondary { border-radius: 10px; }
        .task-actions a { color: #007bff; margin-right: 10px; }
        .task-actions a:hover { color: #0056b3; }
        .comment-section { margin-top: 20px; background-color: #f9f9f9; padding: 15px; border-radius: 8px; }
        .comment-card { background-color: #eef2f7; padding: 10px; border-radius: 8px; margin-bottom: 10px; }
        .comment-form textarea { border-radius: 10px; }
        .comment-form button { background-color: #28a745; border-color: #28a745; border-radius: 10px; }
        .comment-form button:hover { background-color: #218838; border-color: #1e7e34; }
        .toggle-comment { cursor: pointer; color: #007bff; }
        .toggle-comment:hover { color: #0056b3; }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <a href="dashboard.php" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>

        <h2 class="mb-4"><?= $board['name'] ?></h2>

        <!-- Add new list form -->
        <form method="POST" action="create_list.php" class="mb-4 d-flex">
            <input type="hidden" name="board_id" value="<?= $board_id ?>">
            <input type="text" name="list_name" class="form-control me-2" placeholder="Add new list..." required>
            <button class="btn btn-success">Add List</button>
        </form>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($list = $lists->fetch_assoc()): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between">
                            <span><?= $list['name'] ?></span>
                            <div class="task-actions">
                                <a href="edit_list.php?id=<?= $list['id'] ?>"><i class="fas fa-edit"></i></a>
                                <a href="delete_list.php?id=<?= $list['id'] ?>" onclick="return confirm('Delete this list?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $list_id = $list['id'];
                            $tasks = $conn->query("SELECT * FROM tasks WHERE list_id = $list_id ORDER BY position ASC");
                            while ($task = $tasks->fetch_assoc()):
                            ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong><?= $task['title'] ?></strong><br>
                                            <small><?= $task['due_date'] ? 'Due: ' . $task['due_date'] : '' ?></small>
                                        </div>
                                        <div>
                                            <a href="edit_task.php?id=<?= $task['id'] ?>" class="me-2 text-primary"><i class="fas fa-edit"></i></a>
                                            <a href="delete_task.php?id=<?= $task['id'] ?>" class="text-danger" onclick="return confirm('Delete this task?')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>

                                    <!-- Comments Section -->
                                    <div class="comment-section">
                                        <h5>Comments:</h5>
                                        <span class="toggle-comment" onclick="toggleCommentForm(<?= $task['id'] ?>)">
                                            <i class="fas fa-comment"></i> Add/Hide Comment
                                        </span>

                                        <div id="comment-form-<?= $task['id'] ?>" class="mt-3" style="display: none;">
                                            <form method="POST" action="board.php?id=<?= $board_id ?>" class="comment-form">
                                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                <textarea name="comment" class="form-control mb-2" placeholder="Add a comment..." required></textarea>
                                                <button class="btn btn-sm btn-success w-100">Add Comment</button>
                                            </form>
                                        </div>

                                        <div class="mt-3">
                                            <?php
                                            $task_id = $task['id'];
                                            $comments = $conn->query("SELECT * FROM comments WHERE task_id = $task_id ORDER BY created_at DESC");
                                            while ($comment = $comments->fetch_assoc()):
                                            ?>
                                                <div class="comment-card">
                                                    <p><strong><?= $comment['created_at'] ?>:</strong> <?= $comment['comment'] ?></p>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="card-footer">
                            <form method="POST" action="create_task.php">
                                <input type="hidden" name="list_id" value="<?= $list['id'] ?>">
                                <input type="text" name="title" class="form-control mb-2" placeholder="New task..." required>
                                <button class="btn btn-sm btn-secondary w-100">Add Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function toggleCommentForm(taskId) {
            const form = document.getElementById('comment-form-' + taskId);
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
