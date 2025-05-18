<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_project'])) {
    $projectId = $_POST['project_id'];
    $stmt = $connection->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    header("Location: report.php");
    exit;
}

// Handle edit (move) request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_project'])) {
    $projectId = $_POST['project_id'];
    $newStatus = $_POST['new_status'];
    $stmt = $connection->prepare("UPDATE clients SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $projectId);
    $stmt->execute();
    header("Location: report.php");
    exit;
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
    <title>ConstructStore - Project Materials Report</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
     <header>
        <div class="header-top">
            <div class="logo">
                <img src="../assets/images/logo.png" alt="Dashboard Logo" class="logo">
            </div>
            <nav>
    <ul>
        <li><a href="index.php" class="text-white <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="../admin/project.php" class="text-white <?php echo basename($_SERVER['PHP_SELF']) == 'project.php' ? 'active' : ''; ?>">Project</a></li>
        <li><a href="report.php" class="text-white <?php echo basename($_SERVER['PHP_SELF']) == 'report.php' ? 'active' : ''; ?>">Reports</a></li>
        <li><a href="members.php" class="text-white <?php echo basename($_SERVER['PHP_SELF']) == 'members.php' ? 'active' : ''; ?>">Members</a></li>
    </ul>
</nav>
            <div class="profile d-flex align-items-center">
                <!-- Use Flexbox for alignment -->
                <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="fas fa-user"></i>
                </a>
                <!-- Profile Modal -->
                <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-end"> <!-- Align modal to the right -->
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <!-- Profile Card -->
                                <div class="card" style="background: white; border-radius: 20px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); width: 360px; padding: 20px; text-align: center; position: relative;">
                                    <img src="../assets/images/apasdek.jpg" alt="Profile" class="profile-img" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 5px solid white; position: absolute; top: -50px; left: 50%; transform: translateX(-50%); box-shadow: 0 5px 15px rgba(0,0,0,0.15);">
                                    <div class="top-actions" style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #f64f59;">
                                       
                                    </div>
                                    <h2 style="margin-top: 60px; font-size: 22px;">Apasdek Construction Services</h2>
                                    <p class="location" style="color: gray; font-size: 14px; margin: 5px 0 15px;">Macasandig, Cagayan de Oro, Philippines</p>
                                    <p class="role" style="font-size: 14px; color: #666; margin: 5px 0;">Engineering Service · Contractor · Construction Company</p>
                                    <div class="stats" style="display: flex; justify-content: space-around; margin: 20px 0;">
                                        <div style="text-align: center;">
                                            <span style="display: block; font-weight: bold; font-size: 18px;">65</span>Friends
                                        </div>
                                        <div style="text-align: center;">
                                            <span style="display: block; font-weight: bold; font-size: 18px;">43</span>Photos
                                        </div>
                                        <div style="text-align: center;">
                                            <span style="display: block; font-weight: bold; font-size: 18px;">21</span>Comments
                                        </div>
                                    </div>
                                   <a href="https://www.facebook.com/javeboi/"> <button class="btn" style="background: linear-gradient(135deg, #f64f59, #c471ed); color: white; padding: 10px 25px; border: none; border-radius: 25px; font-size: 14px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: background 0.3s;">Show more</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

    <div class="container my-5">
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
   
</body>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Dynamic Messages -->
    <script>
        // Function to add a new message
        document.getElementById('sendMessageBtn').addEventListener('click', function() {
            const messageInput = document.getElementById('messageInput');
            const messageBox = document.querySelector('.message-box');

            if (messageInput.value.trim() !== "") {
                const newMessage = document.createElement('div');
                newMessage.className = 'message alert alert-info'; // Change class for different message types
                newMessage.textContent = messageInput.value;
                messageBox.appendChild(newMessage);

                // Scroll to the bottom of the message box
                messageBox.scrollTop = messageBox.scrollHeight;

                // Clear the input field
                messageInput.value = '';
            }
        });
    </script>
</body>

</html>
