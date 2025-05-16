<?php
$conn = new mysqli("localhost", "root", "", "constructstore");
$list_id = $_GET['id'] ?? 0;
$list = $conn->query("SELECT * FROM task_lists WHERE id = $list_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $conn->query("UPDATE task_lists SET name = '$name' WHERE id = $list_id");
    header("Location: board.php?id=" . $list['board_id']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="container py-5">
    <h3><i class="fas fa-edit"></i> Edit List</h3>
    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">List Name</label>
            <input type="text" name="name" class="form-control" value="<?=($list['name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update List</button>
        <a href="board.php?id=<?= $list['board_id'] ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </form>
</body>
</html>
