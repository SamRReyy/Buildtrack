<?php
session_start();

require 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt= $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt ->execute([$username]);
    $users = $stmt ->fetch (PDO::FETCH_ASSOC);

    if ($users && password_verify($password, $users['password'])){
        header ('Location: dash/index.php');
        exit ();

    }else {
        $_SESSION['error'] = "Invalid Username and Password";
        header ('Location:login.php');
        exit();
    }
}