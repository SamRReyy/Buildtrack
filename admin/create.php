<?php
$name = "";
$start_date = "";
$end_date = "";
$duration = "";
$address = "";
$errorMessage = "";
$successMessage = "";

// Database connection setup
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "construct";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $address = $_POST["address"];

    do {
        if (empty($name) || empty($start_date) || empty($end_date) || empty($address)) {
            $errorMessage = "All fields are required.";
            break;
        }

        // Format duration
        $duration = date("F j, Y", strtotime($start_date)) . " - " . date("F j, Y", strtotime($end_date));

        // Use prepared statement
        $sql = "INSERT INTO clients (name, duration, address) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);

        if ($stmt === false) {
            $errorMessage = "Failed to prepare statement: " . $connection->error;
            break;
        }

        // Bind and execute
        $stmt->bind_param("sss", $name, $duration, $address);
        $success = $stmt->execute();

        if (!$success) {
            $errorMessage = "Failed to execute query: " . $stmt->error;
            break;
        }

        // Clear fields after success
        $name = $start_date = $end_date = $address = "";
        $successMessage = "Project added successfully.";

        // Redirect
        header("Location: project.php");
        exit;

    } while (false);
}

$connection->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ConstrucStore - New Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>New Project</h2>

        <!-- Error Alert -->
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Success Alert -->
        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $successMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Duration</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="start_date" value="<?php echo $start_date; ?>" required>
                </div>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="end_date" value="<?php echo $end_date; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-outline-secondary" href="project.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
