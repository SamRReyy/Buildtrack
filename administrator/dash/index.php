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

// Fetch total number of users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $connection->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];

// Fetch first and last names of users
$usersQuery = "SELECT firstname, lastname FROM users";
$usersResult = $connection->query($usersQuery);
$users = $usersResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="/ConstructStore/administrator/styles/style.css">
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
                     
                    <a href="index.php" class="active">
                        <i class="fas fa-tachometer-alt me-2"></i> <!-- Dashboard Icon -->
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="reports.php">
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
                        <i class="fas fa-sign-out-alt me-2"></i> <!-- Logout Icon -->
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <div class="topbar">
                <div class="search">
                    <input type="text" placeholder="search. . . " class="form-control">
               </div>
                <h2> Hi Admin!</h2>
                <div class="user-profile text-center">
                    <img src="styles/manager.png" alt="user" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto; ">
                    <span style="display: block; margin-top: 5px; font-weight: bold; text-align: center;">ADMIN</span>
                </div>
            </div>
        
            <div class="container center-content">
                <div class="row">
                    <!-- Total Users Card -->
                    <div class="col-md-6">
                        <div class="card user-card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <h2 class="text-primary" id="totalUsers"><?= $totalUsers ?></h2>
                            </div>
                        </div>
                    </div>

                    <!-- User List Card -->
                    <div class="col-md-6">
                        <div class="card user-card">
                            <div class="card-body">
                                <h5 class="card-title text-center">User List</h5>
                                <div class="user-list">
                                    <ul class="list-group" id="userList">
                                        <?php foreach ($users as $user): ?>
                                            <li class="list-group-item">
                                                <?= htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
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