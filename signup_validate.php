<?php
session_start();
require 'includes/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Get form inputs
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm) {
        $_SESSION['error'] = "Passwords do not match.";
        header('Location: signup.php');
        exit();
    }

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header('Location: signup.php');
        exit();
    }

    // Check if username already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Username already exists.";
        header('Location: signup.php');
        exit();
    }

    // Check if email already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email already exists.";
        header('Location: signup.php');
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$firstname, $lastname, $username, $email, $hashedPassword])) {
        $_SESSION['success'] = "Your account has been created. You can now log in.";
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['error'] = "There was an error while creating your account.";
        header('Location: signup.php');
        exit();
    }
}