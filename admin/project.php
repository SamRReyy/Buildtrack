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
            <a href="profile.php" class="me-3"><i class="fas fa-user"></i></a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#messageModal" class="me-3"><i class="fas fa-robot"></i></a>
                <a href="../login.html" class="btn btn-danger p-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-sign-out-alt"></i>
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

                <!-- Button with Bootstrap styling -->
            </div>
            </section>
            <div class="container my-5">
            <h2 class="fw-bold">LIST OF PROJECTS</h2>
            <a href="report.php" class="btn btn-info mb-3">📄 VIEW REPORT</a>
            <a class="btn btn-primary mb-3" href="#" role="button" data-bs-toggle="modal" data-bs-target="#addProjectModal">
            <i class="fas fa-plus me-2"></i> NEW PROJECT
            </a>
            <div class="row">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "construct";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT * FROM clients";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }

    while ($row = $result->fetch_assoc()) {
        $project_id = $row['id'];

        // Fetch tasks for the current project
        $task_query = "SELECT * FROM tasks WHERE project_id = $project_id";
        $task_result = $connection->query($task_query);

        echo "
        <div class='col-md-4 mb-4'>
            <div class='card'>
                <div class='card-body position-relative'>
                    <!-- Status Dropdown -->
                    <form action='update_status.php' method='POST' class='position-absolute top-0 end-0 m-2'>
                        <input type='hidden' name='project_id' value='{$project_id}'>
                        <select name='status' class='form-select form-select-sm' onchange='this.form.submit()'>
                            <option value='Upcoming' class='status-upcoming' " . ($row['status'] === 'Upcoming' ? 'selected' : '') . ">Upcoming</option>
                            <option value='In Progress' class='status-in-progress' " . ($row['status'] === 'In Progress' ? 'selected' : '') . ">In Progress</option>
                            <option value='Done' class='status-done' " . ($row['status'] === 'Done' ? 'selected' : '') . ">Done</option>
                        </select>
                    </form>
                    <h5 class='card-subtitle mb-2 text-muted'>Project Name: {$row['name']}</h5>
                    <h6 class='card-title'>Project ID: {$row['id']}</h6>
                    
                    <div class='card mb-2'>
                        <div class='card-body p-2'>
                            <p class='card-text mb-0'><strong>Duration:</strong> {$row['duration']}</p>
                            <p class='card-text mb-0'><strong>Location:</strong> {$row['address']}</p>
                        </div>
                    </div>
                    <p class='card-text'><strong>Created At:</strong> {$row['created_at']}</p>
                    <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>
                     <i class='fas fa-trash'></i> 
                    </a>
                    <a href='add_task.php?id={$row['id']}' class='btn btn-success btn-sm mt-2'>
                        <i class='fas fa-tasks'></i>
                    </a>
                    <hr>
                    <h6>Tasks:</h6>
        ";

        // Display tasks for the current project as small cards
        if ($task_result->num_rows > 0) {
            while ($task = $task_result->fetch_assoc()) {
                // Calculate the difference between the current date and the due date
                $current_date = new DateTime();
                $due_date = new DateTime($task['due_date']);
                $interval = $current_date->diff($due_date);

                // Determine the color based on the number of days remaining
                $due_date_color = '';
                if ($interval->invert == 1) {
                    // If the due date has passed
                    $due_date_color = 'text-danger'; // Red for overdue
                } elseif ($interval->days <= 3) {
                    // If the due date is within 3 days
                    $due_date_color = 'text-warning'; // Yellow for near due
                } else {
                    // If the due date is far away
                    $due_date_color = 'text-success'; // Green for safe
                }

                echo "
                <div class='card mb-2'>
                    <div class='card-body p-2'>
                        <h6 class='card-title'>Task Name: " . htmlspecialchars($task['task_name']) . "</h6>
                        <div class='form-check'>
                            <input type='checkbox' class='form-check-input' id='task-complete-{$task['id']}' " . ($task['is_complete'] ? 'checked' : '') . " onchange='updateTaskStatus({$task['id']}, this.checked)'>
                            <label class='form-check-label' for='task-complete-{$task['id']}'>Mark as Complete</label>
                        </div>
                        <button class='btn btn-sm btn-info toggle-task-details' data-task-id='{$task['id']}'>
                            <i class='fas fa-eye'></i>
                        </button>
                        <div class='task-details' id='task-details-{$task['id']}' style='display: none;'>
                            <p class='card-text mb-1'><strong>Works:</strong> " . htmlspecialchars($task['works']) . "</p>
                            <p class='card-text mb-1'><strong>Start Date:</strong> " . htmlspecialchars($task['start_date']) . "</p>
                            <p class='card-text mb-1'><strong>End Date:</strong> " . htmlspecialchars($task['end_date']) . "</p>
                            <p class='card-text mb-1 {$due_date_color}'>
                                <strong>Due Date:</strong> " . htmlspecialchars($task['due_date']) . "
                            </p>
                            <small class='{$due_date_color}'>
                                " . ($interval->invert == 1 ? "This task is overdue!" : ($interval->days <= 3 ? "The due date is approaching in {$interval->days} day(s)." : "The due date is in {$interval->days} day(s).")) . "
                            </small>
                            <p class='card-text mb-1'><strong>Personnel:</strong> " . htmlspecialchars($task['personnel']) . "</p>
                            <p class='card-text mb-1'><strong>Location:</strong> " . htmlspecialchars($task['location']) . "</p>
                            <div class='d-flex justify-content-between'>
                                <a href='task_list.php?id={$task['id']}' class='btn btn-sm btn-warning'>
                                    <i class='fas fa-pen'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p class='card-text text-muted'>No tasks added yet.</p>";
        }

        echo "
                </div>
            </div>
        </div>
        ";
    }

    // Update task completion status
    $update_task_sql = "UPDATE tasks SET is_complete = 1 WHERE id = 1";
    $connection->query($update_task_sql);
    ?>
</div>
        </div>
    </main>

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
                     <img src="../ConstructStore/assets/images/logo.png" alt="Dashboard Logo" class="logo">
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

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_project.php" method="POST">
                        <div class="mb-3">
                            <label for="projectName" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="projectName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="projectDuration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="projectDuration" name="duration" required>
                        </div>
                        <div class="mb-3">
                            <label for="projectAddress" class="form-label">Location</label>
                            <input type="text" class="form-control" id="projectAddress" name="address" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <script>
    // Add event listeners to all "View Task" buttons
    document.querySelectorAll('.toggle-task-details').forEach(button => {
        button.addEventListener('click', function () {
            const taskId = this.getAttribute('data-task-id');
            const taskDetails = document.getElementById(`task-details-${taskId}`);
            
            // Toggle visibility
            if (taskDetails.style.display === 'none') {
                taskDetails.style.display = 'block';
                this.innerHTML = "<i class='fas fa-eye-slash'></i> Hide Task";
            } else {
                taskDetails.style.display = 'none';
                this.innerHTML = "<i class='fas fa-eye'></i> ";
            }
        });
    });
    </script>

    <script>
    function updateTaskStatus(taskId, isComplete) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_task_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText); // Optional: Log the response for debugging
            }
        };
        xhr.send(`task_id=${taskId}&is_complete=${isComplete ? 1 : 0}`);
    }
    </script>
</body>

</html>