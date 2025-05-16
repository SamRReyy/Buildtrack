
<!-- KAYAOS NI -->

<?php
session_start(); // Start the session to manage user data
?>
<!DOCTYPE html>
<html>
    <head>
        <title>login</title> <!-- Page title -->
        <link rel="stylesheet" href="styles/styles.css"> <!-- Link to custom styles -->
        <link rel="stylesheet" href="assets/styles/bootstrap.min.css"> <!-- Link to Bootstrap styles -->
        <meta charset="utf-8"> <!-- Set character encoding -->
        <style>
            /* Styling for error alert messages */
            .alert-danger {
                background-color: #ffebee;
                border-color: #ef9a9a;
                color: #c62828;
            }
            /* Styling for success alert messages */
            .alert-success {
                background-color: #e8f5e9;
                border-color: #a5d6a7;
                color: #2e7d32;
            }
            /* General alert styling */
            .alert {
                border-radius: 8px;
                padding: 15px 20px;
                font-size: 15px;
                margin-bottom: 20px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.05);
                transition: all 0.3s ease;
            }
        </style>
    </head>
    <body>
        <div class="container"> <!-- Main container -->
            <div class="card"> <!-- Card for form and content -->
               <img src="../ConstructStore/assets/images/logo.png" alt="Dashboard Logo" class="logo">
                
                <!-- Display error message if set in session -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?=$_SESSION['error']; unset($_SESSION['error']);?> <!-- Show and clear error -->
                    </div>
                <?php endif; ?>
                
                <!-- Display success message if set in session -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?=$_SESSION['success']; unset($_SESSION['success']);?> <!-- Show and clear success -->
                    </div>
                <?php endif; ?>
                
                <!-- Signup form -->
                <form action="signup_validate.php" method="POST">
                    <input class="form-control" type="text" placeholder="Firstname" name="firstname" required> <!-- Firstname input -->
                    <input class="form-control" type="text" placeholder="Lastname" name="lastname" required> <!-- Lastname input -->
                    <input class="form-control" type="text" placeholder="Username" name="username" required> <!-- Username input -->
                    <input class="form-control" type="email" placeholder="Email" name="email" required> <!-- Email input -->
                    <input class="form-control" type="password" placeholder="Password" name="password" required> <!-- Password input -->
                    <input class="form-control" type="password" placeholder="Re-enter Password" name="confirm_password" required> <!-- Confirm password input -->
                    
                    <button type="submit">Signup</button> <!-- Submit button -->
                </form>
                
                <!-- Link to login page -->
                <p>Already have an account? <a href="login.php">login</a></p>
            </div>
        </div>
    </body>
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</html>
