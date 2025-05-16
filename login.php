<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$siteKey = $_ENV['RECAPTCHA_SITE_KEY'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="assets/styles/bootstrap.min.css">
    <meta charset="utf-8">
    <style>
        .alert-danger {
            background-color: #ffebee;
            border-color: #ef9a9a;
            color: #c62828;
        }
        .alert-success {
            background-color: #e8f5e9;
            border-color: #a5d6a7;
            color: #2e7d32;
        }
        .alert {
            border-radius: 8px;
            padding: 15px 20px;
            font-size: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <img src="../ConstructStore/assets/images/logo.png" alt="Dashboard Logo" class="logo">
        <div class="card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form action="login_validate.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button class="btn btn-primary" type="submit">Login</button>
            
                <!-- Google reCAPTCHA widget -->
              
                <div class="g-recaptcha" data-sitekey="<?= ($siteKey) ?>"></div>


            </form>
                
            <div class="text-center mt-3">
                <a href="googleAuth/google-login.php" class="btn btn-danger w-100">
                    <i class="mdi mdi-google me-2"></i> Sign in with Google

                </a>
        </div>

            <p>Don't have an account? <a href="signup.php">Signup</a></p>
            <p>Forgot Password? <a href="forgot-password_validate.php">Click Here!</a></p>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>