<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);

$client_id = $_GET['id'] ?? null;
if (!$client_id) {
    header("location: project.php");
    exit;
}

// Add new material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_material'])) {
    $material_name = $_POST["material_name"];
    $quantity = $_POST["quantity"];
    $unit_price = $_POST["unit_price"];

    if (!empty($material_name) && is_numeric($quantity) && is_numeric($unit_price)) {
        $sql = "INSERT INTO materials (client_id, material_name, quantity, unit_price)
                VALUES ($client_id, '$material_name', $quantity, $unit_price)";
        $connection->query($sql);
    }
}

// Delete material
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $connection->query("DELETE FROM materials WHERE id=$delete_id");
}

$materials = $connection->query("SELECT * FROM materials WHERE client_id=$client_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Materials</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Materials for Project ID: <?= $client_id ?></h2>
    <form method="POST" class="mb-4">
        <div class="row g-2">
            <div class="col">
                <input type="text" name="material_name" class="form-control" placeholder="Material Name" required>
            </div>
            <div class="col">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" name="unit_price" class="form-control" placeholder="Unit Price" required>
            </div>
            <div class="col">
                <button type="submit" name="add_material" class="btn btn-success">Add Material</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped bg-white">
        <thead>
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Added On</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $materials->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['material_name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['unit_price'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>

                    <a href="edit_material.php?id=<?= $row['id'] ?>&client_id=<?= $client_id ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="materials.php?id=<?= $client_id ?>&delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this material?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="project.php" class="btn btn-outline-secondary">Back to Projects</a>
</div>
</body>
</html>
