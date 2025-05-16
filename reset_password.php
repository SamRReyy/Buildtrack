<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Code</title>
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
      >
             <img src="images/2.jpg" alt="This is the logo">
            <h4 class="text-white">Enter Your Email To Continue</h4>
            <form action="reset_password_validate.php" method="POST">
            <?php if (isset($_SESSION['success'])): ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?=$_SESSION['success']; unset ($_SESSION['success']);?>
                    </div>
                    <?php endif; ?>
                   <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$_SESSION['error']; unset ($_SESSION['error']);?>
                    </div>
                    <?php endif; ?>
                  

                <input type="password" placeholder="Enter New Password" name="newPassword" required>
                <input type="password" placeholder="Re-enter New Password" name="confirm_newPassword" required>
            
                <button class="btn btn-primary" type="submit">Submit</button>
                
            </form>
        </div>
    </div>
</body>

</html>