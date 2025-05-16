<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "constructstore");

// Handle connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all boards
$result = $conn->query("SELECT * FROM boards ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Boards - ConstructStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/styles/style.css">
    <link rel="stylesheet" href="../assets/styles/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/styles/custom.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>       
</head>
<body class="p-4 bg-light">
<header>
        <div class="header-top">
            <div class="logo">
                <img src="../assets/images/7.png" alt="this is the logo">
            </div>
            <div class="profile d-flex align-items-center">
                <!-- Use Flexbox for alignment -->
                <a href="manage_users.php" class="me-3"><i class="fas fa-user"></i></a>
                <!-- Profile icon -->
                <!-- Message Icon -->
                <a href="#" data-bs-toggle="modal" data-bs-target="#messageModal" class="me-3"><i class="fas fa-robot"></i></a>
                <!-- Logout Button -->
                <a href="../login.php" 
                 class="btn btn-danger p-0 d-flex align-items-center justify-content-center" 
                 style="width: 40px; height: 40px;" onclick="return confirm('Are you sure you want to logout?')">
                     <i class="fas fa-sign-out-alt"></i>
                </a>

                    <!-- Logout icon -->
                </a>
            </div>
        </div>
     
    </header>
    <div class="container">
        <h2 class="mb-4">🧱 Construction Boards</h2>

        <!-- Create new board -->
        <form method="POST" action="create_board.php" class="d-flex mb-4">
            <input type="text" name="board_name" class="form-control me-2" placeholder="New board name..." required>
            <button class="btn btn-success">+ Create Board</button>
        </form>

        <!-- Boards Display -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($board = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?=($board['name']) ?></h5>
                                <a href="board.php?id=<?= $board['id'] ?>" class="btn btn-primary btn-sm">View Board</a>
                            </div>
                            <div class="card-footer text-muted small">
                                Created: <?= date("F j, Y", strtotime($board['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No boards yet. Create your first one above! 👆</p>
            <?php endif; ?>
        </div>
    </div>
      <!-- Footer -->
      <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <!-- Contact Us Section -->
                <div class="col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i>09465347640</li>
                        <li><i class="fas fa-envelope me-2"></i>constructstore@gmail.com</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i>Landing, Malaybalay City, Bukidnon, Philippines</li>
                    </ul>
                </div>

                <!-- Sitemap and Social Media Section -->
                <div class="col-md-4 mb-4">
                    <div class="row">
                        <!-- Sitemap Section -->
                        <div class="col-6">
                            <h5>Sitemap</h5>
                            <ul class="list-unstyled">
                                <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                                <li><a href="project.php" class="text-white text-decoration-none">Projects</a></li>
                                <li><a href="report.php" class="text-white text-decoration-none">Reports</a></li>
                                <li><a href="members.php" class="text-white text-decoration-none">Members</a></li>
                            </ul>
                        </div>

                        <!-- Social Media Icons (Vertical) -->
                        <div class="col-6">
                            <h5>Follow Us</h5>
                            <div class="social-media-icons d-flex flex-column">
                                <a href="https://facebook.com" class="text-white mb-3"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://youtube.com" class="text-white mb-3"><i class="fab fa-youtube"></i></a>
                                <a href="https://instagram.com" class="text-white mb-3"><i class="fab fa-instagram"></i></a>
                                <a href="https://tiktok.com" class="text-white mb-3"><i class="fab fa-tiktok"></i></a>
                                <a href="https://twitter.com" class="text-white"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo Section -->
                <div class="col-md-4 mb-4 text-md-end">
                    <img src="../assets/images/7.png" alt="Logo" class="footer-logo" style="width: 100px;">
                    <p class="mt-2">"WE BUILD FOR THE FUTURE"</p>
                </div>
            </div>

            <!-- All Rights Reserved Section -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; ConstructStore. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>

  
</html>
