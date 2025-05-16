<?php 
session_start();
require 'includes/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $reset_code= rand (100000, 999999);
        $update = $pdo ->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
        $update->execute([$reset_code, $email]);
        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);
        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail ->Username='anothergamer.com@gmail.com'; // SMTP username
            $mail->Password = 'pohq lljb cabq qhri'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to

            $mail->setFrom('another.com@gmail.com', 'Joshua Caranay');  // Sender's email and name
            $mail->addAddress($email, 'User'); // Add a recipient
            $mail ->isHTML(true);
            $mail->Subject = 'Password Reset Code';
            $mail->Body = "
            <div style='background color-white; padding: 20px; font-family: Arial, sans-serif, border-radius: 5px;'>
                <h2>Password Reset Code</h2>
                <p> Hello, Use the code below to reset your password! $reset_code</p>
                <p>If you did not request this, please ignore this email.</p>";
                $mail->AltBody="Hello user! use the code to reset: {$reset_code}";
                $mail->send();

                $_SESSION['email_sent'] = true;
                $_SESSION['success'] = "A verification code has been sent to your email";
                header('Location: send-code.php');
    

            // Code to send the reset password link to the user's email
            $_SESSION['success'] = "A reset password link has been sent to your email.";
            header('Location: send-code.php');
            exit();

        } catch (Exception $e) {
                $_SESSION['error'] = "Failed to send email. Please try again later.";
                header('Location: forgot-password_validate.php');
                exit();
            }
    } else {
        $_SESSION['error'] = "Email not found in our records.";
        header('Location: forgot-password_validate.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
        <link rel="stylesheet"href="styles/styles.css">
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
            transition: all 0.3s ease;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card">
             <img src="images/2.jpg" alt="This is the logo">
            <h4 class="text-white">Enter Your Email To Continue</h4>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$_SESSION['error']; unset ($_SESSION['error']);?>
                        </div>
                        <?php endif;?>
                        <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">  
                            <?=$_SESSION['success']; unset ($_SESSION['success']);?>
                    </div>
                    <?php endif; ?>
                    <form action = "forgot-password_validate.php" method ="POST">
                        <input type="email" placeholder="Enter Email" name="email">
                        <button class="btn btn-primary" type="submit">Send Code</button>
                    </form>
            </div>
        </div>
    </body>
</html>