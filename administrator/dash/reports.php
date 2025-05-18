<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch projects by status
$statuses = ['Upcoming', 'In Progress', 'Done'];
$projects = [];

foreach ($statuses as $status) {
    $stmt = $connection->prepare("SELECT * FROM clients WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $projects[$status] = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" type="image/png" href="images/12.jpg">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="dashboard">
        <div class="sidebar">
             <div class="heads"> D A S H B O A R D
                <img src="styles/logo.png" alt="Dashboard Logo" class="logo">
            </div>
            <ul class="menu">
                <li>
                    <a href="index.php">
                        <i class="fas fa-tachometer-alt me-2"></i> <!-- Dashboard Icon -->
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="reports.php" class="active">
                        <i class="fas fa-chart-bar me-2"></i> <!-- Reports Icon -->
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="account.php" >
                        <i class="fas fa-users me-2"></i> <!-- Accounts Icon -->
                        <span>Accounts</span>
                    </a>
                </li>
                <li>
                    <a href="../login.php">
                        <i class="fas fa-users me-2"></i> <!-- Members Icon -->
                        <span>Members</span>
                    </a>
                </li>
                <li>
                    <a href="../login.php">
                        <i class="fas fa-sign-out-alt me-2"></i> <!-- Logout Icon -->
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content">

            <div class="topbar">
                <div class="search">
                    <input type="text" placeholder="search. . . ">
                </div>
                <h2> Hi Admin!</h2>
                <div class="user-profile text-center">
                    <img src="styles/manager.png" alt="user" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto;">
                    <span style="display: block; margin-top: 5px; font-weight: bold; text-align: center;">ADMIN</span>
                </div>
            </div>

            <!-- Adjusted Content - Wider Table & Card -->
            <div class="content">
                <div class="container mt-3">
                    <div class="row">
                        <!-- Upcoming Section -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Upcoming</h5>
                                    <?php if (!empty($projects['Upcoming'])): ?>
                                        <ul class="list-group">
                                            <?php foreach ($projects['Upcoming'] as $project): ?>
                                                <li class="list-group-item">
                                                    <strong><?= htmlspecialchars($project['name']) ?></strong><br>
                                                    Duration: <?= htmlspecialchars($project['duration']) ?><br>
                                                    Address: <?= htmlspecialchars($project['address']) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-center text-muted">No upcoming projects.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- In Progress Section -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">In Progress</h5>
                                    <?php if (!empty($projects['In Progress'])): ?>
                                        <ul class="list-group">
                                            <?php foreach ($projects['In Progress'] as $project): ?>
                                                <li class="list-group-item">
                                                    <strong><?= htmlspecialchars($project['name']) ?></strong><br>
                                                    Duration: <?= htmlspecialchars($project['duration']) ?><br>
                                                    Address: <?= htmlspecialchars($project['address']) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-center text-muted">No projects in progress.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Done Section -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Done</h5>
                                    <?php if (!empty($projects['Done'])): ?>
                                        <ul class="list-group">
                                            <?php foreach ($projects['Done'] as $project): ?>
                                                <li class="list-group-item">
                                                    <strong><?= htmlspecialchars($project['name']) ?></strong><br>
                                                    Duration: <?= htmlspecialchars($project['duration']) ?><br>
                                                    Address: <?= htmlspecialchars($project['address']) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-center text-muted">No completed projects.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>