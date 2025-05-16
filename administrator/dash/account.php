<?php
session_start();
require '../includes/db.php';

// Update user role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $userId = $_POST['user_id'];
    $newRole = $_POST['role'];

    // Debugging log
    error_log("User ID: $userId, New Role: $newRole");

    // Update the user's role in the database
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$newRole, $userId]);

    // Set success message and redirect
    $_SESSION['success'] = "User role updated successfully.";
    header("Location: account.php");
    exit();
}

// Delete user
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

    $_SESSION['success'] = "User deleted successfully.";
    header("Location: account.php");
    exit();
}

// Fetch all users
$stmt = $pdo->query("SELECT id, username, firstname, lastname, email, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userExists = $stmt->fetchColumn();

    if ($userExists) {
        $_SESSION['error'] = "The username '$username' is already taken. Please choose another.";
    } else {
        // Insert the new user
        $stmt = $pdo->prepare("INSERT INTO users (username, firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $firstname, $lastname, $email, $password, $role]);

        $_SESSION['success'] = "User added successfully.";
        header("Location: account.php");
        exit();
    }
}

$construction_roles = [
    'Project Manager',
    'Civil Engineer',
    'Architect',
    'Site Supervisor',
    'Quantity Surveyor',
    'Construction Foreman',
    'MEP Engineer'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
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
                    <a href="reports.php">
                        <i class="fas fa-chart-bar me-2"></i> <!-- Reports Icon -->
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="account.php" class="active">
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
                    <input type="text" placeholder="Search...">
                </div>
                <h2> Hi Admin!</h2>
                <div class="user-profile text-center">
                    <img src="styles/manager.png" alt="user" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto;">
                    <span style="display: block; margin-top: 5px; font-weight: bold; text-align: center;">ADMIN</span>
                </div>
            </div>

            <div class="container mt-4">
                <h2 class="mb-4">User Management</h2>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <!-- Add User Form -->
                <div class="card mb-4" style="min-width: 100%;">
                    <div class="card-header bg-primary text-white" style="font-size: 1.25rem; text-align: center;">
                        Add New User
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="col-md-1">
                                    <select name="role" class="form-select" required>
                                        <?php foreach ($construction_roles as $role): ?>
                                            <option value="<?= htmlspecialchars($role) ?>"><?= htmlspecialchars($role) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" name="add_user" class="btn btn-success w-100">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- User Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Change Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['firstname']) ?></td>
                                <td><?= htmlspecialchars($user['lastname']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td>
                                    <form method="POST" class="d-flex">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <select name="role" class="form-select me-2">
                                            <?php foreach ($construction_roles as $role): ?>
                                                <option value="<?= htmlspecialchars($role) ?>" <?= $user['role'] === $role ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($role) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" name="update_role" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen fa-fw"></i> 
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="fas fa-trash fa-fw"></i> 
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>