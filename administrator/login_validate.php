<?php
session_start();

require 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt= $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($users && password_verify($password, $users['password'])) {
        if ($users['role'] !== 'admin') {
            $_SESSION['error'] = "You are not the admin.";
            header('Location: login.php');
            exit();
        }
        header('Location: dash/index.php');
        exit();
    } else {
        $_SESSION['error'] = "Invalid Username and Password";
        header('Location: login.php');
        exit();
    }
}