<?php 
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
        <link rel="stylesheet"href="styles/styles.css">
        <meta charset="utf-8">
    </head>
    <body>
        <div class="container">
            <div class="card">
                
            <img src="../administrator/styles/logo.png" alt="This is the logo">
                    <div class ="card-body">
                        <?php if (isset($_SESSION['error'])):?>
                            <div class= "alert aler-danger" role="alert">
                                <?=$_SESSION['error'];unset($_SESSION['success']);?>
                        </div>
                        <?php endif;?>
                        <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$_SESSION['success']; unset ($_SESSION['success']);?>
                    </div>
                    <?php endif; ?>
                    <form action = "login_validate.php" method= "POST">
                        <input type="text" placeholder="Username" name="username">
                        <input type="password" placeholder="Password" name="password">
                        <button class="btn btn-primary" type="submit">Login</button>
                       
                        
                    </form>
                    <p>Don't have Account? <a href="signup.php"> Signup</a></p>
                    <p>Forgot Password? <a href="forgot-password.php"> Click Here! </a></p>
            </div>
        </div>
    </body>
</html>
