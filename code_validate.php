<?php

session_start(); // Start the session to manage user data

require 'includes/db.php'; // Include database connection

if($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if the request is a POST method
    
    $enteredCode = $_POST['code']; // Get the code entered by the user

    $email = $_SESSION['email']; // Get the email from the session

    // Check if email is not set in the session
    if(!isset($_SESSION['email'])) {
        $_SESSION['error'] = "Session expired or invalid access."; // Set error message
        header('Location: forgot-password.php'); // Redirect to forgot password page
        exit(); // Stop further execution
    }

    // Prepare a query to get the reset code for the email
    $stmt = $pdo->prepare("SELECT reset_code FROM users WHERE email = ?");
    $stmt -> execute([$email]); // Execute the query with the email
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user data

    if($user) { // Check if user exists

        // Check if the entered code matches the reset code
        if($enteredCode === $user['reset_code']) {
            $_SESSION['reset_email'] = $email; // Save email in session
            $_SESSION['reset_code_verified'] = true; // Mark code as verified

            header('Location: reset_password.php'); // Redirect to reset password page
            exit(); // Stop further execution
        } else {
            $_SESSION['error'] = "Incorrect code. Please try again."; // Set error message
            header('Location: send-code.php'); // Redirect to send code page
            exit(); // Stop further execution
        }
    } else {
        $_SESSION['error'] = "No user found with that email"; // Set error message
        header('Location: send-code.php'); // Redirect to send code page
        exit(); // Stop further execution
    }
}
?>