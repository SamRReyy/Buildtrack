<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConstructStore</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <main>
        <!-- Hero Section -->
        <section class="hero text-black text-center py-5">
            <!-- Bootstrap container to center content -->
            <div class="container">
                <!-- Main heading with Bootstrap classes -->
                <h2 class="display-4 text-white fw-bold glowing-border-text">
  "WE BUILD MORE THAN STRUCTURES—WE BUILD TRUST"
</h2>

    <div class="container text-center">
      
        <div class="row justify-content-center">
            <!-- Member 1 -->
            <div class="col-md-4">
                <div class="member-card">
                    <img src="../assets/images/milcky.jpg" alt="Profile Picture" class="member-img">
                    <div class="card-body">
                        <label style="color: white;">Student ID</label>
                        <input type="text" value="2301104471" disabled>
                        <label style="color: white;">Name</label>
                        <input type="text" value="Milcky Jhones Francisco" disabled>
                        <label style="color: white;">Email</label>
                        <input type="text" value="milckyjhonesfrancisco@gmail.com" disabled>
                    </div>
                </div>
            </div>

            <!-- Member 2 -->
            <div class="col-md-4">
                <div class="member-card">
                <img src="../assets/images/sam.jpg" alt="Profile Picture" class="member-img">
                    <div class="card-body">
                        <label style="color: white;">Student ID</label>
                        <input type="text" value="2301108902" disabled>
                        <label style="color: white;">Name</label>
                        <input type="text" value="Sam Anthony Rey" disabled>
                        <label style="color: white;">Email</label>
                        <input type="text" value="230113505@student.edu.buksu.ph" disabled>
                    </div>
                </div>
            </div>

            <!-- Member 3 -->
            <div class="col-md-4">
                <div class="member-card">
                <img src="../assets/images/joshua.jpg" alt="Profile Picture" class="member-img">
                    <div class="card-body">
                        <label style="color: white;">Student ID</label>
                        <input type="text" value="2301103884" disabled>
                        <label style="color: white;">Name</label>
                        <input type="text" value="Joshua Caranay" disabled>
                        <label style="color: white;">Email</label>
                        <input type="text" value="22301103884@student.edu.buksu.ph" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>


        
    </main>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Chatbot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Message Box -->
                    <div class="message-box bg-light p-4 rounded">
                        <!-- Example Messages -->
                        <div class="message alert alert-info">What can i help you today?</div>
                    </div>
                    <!-- Input Area for New Messages -->
                    <div class="input-group mt-3">
                        <input type="text" id="messageInput" class="form-control" placeholder="Type your message...">
                        <button id="sendMessageBtn" class="btn btn-primary" type="button">Send</button>
                    </div>
                </div>
            </div>
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