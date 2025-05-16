<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);

// Get material ID and client ID from query parameters
$material_id = $_GET['id'] ?? null;
$client_id = $_GET['client_id'] ?? null;

if (!$material_id || !$client_id) {
    header("location: project.php");
    exit;
}

$material_name = "";
$quantity = "";
$unit_price = "";
$errorMessage = "";
$successMessage = "";

// Handle GET request (display existing values)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM materials WHERE id = $material_id";
    $result = $connection->query($sql);

    if (!$result || $result->num_rows == 0) {
        header("location: materials.php?id=$client_id");
        exit;
    }

    $row = $result->fetch_assoc();
    $material_name = $row["material_name"];
    $quantity = $row["quantity"];
    $unit_price = $row["unit_price"];
}

// Handle POST request (update)
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_name = $_POST["material_name"];
    $quantity = $_POST["quantity"];
    $unit_price = $_POST["unit_price"];

    if (empty($material_name) || !is_numeric($quantity) || !is_numeric($unit_price)) {
        $errorMessage = "Please enter valid values for all fields.";
    } else {
        $sql = "UPDATE materials SET 
                    material_name = '$material_name',
                    quantity = $quantity,
                    unit_price = $unit_price
                WHERE id = $material_id";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Update failed: " . $connection->error;
        } else {
            $successMessage = "Material updated successfully.";
            header("location: materials.php?id=$client_id");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Material</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Edit Material</h2>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Material Name</label>
            <input type="text" name="material_name" class="form-control" value="<?= htmlspecialchars($material_name) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($quantity) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Unit Price</label>
            <input type="number" step="0.01" name="unit_price" class="form-control" value="<?= htmlspecialchars($unit_price) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="materials.php?id=<?= $client_id ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
