<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet"href="styles/styles.css">
    <meta charset="utf-8">
</head>
<body>
    <div class="container">
        <div class="card">
        <img src="images/COTLOGO.png" alt="Logo" class="logo">
      

            <?php session_start(); ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

           
            <p><strong>Enter new password</strong></p>

            <form action="new-password_validate.php" method="POST">
                <input type="password" name="password" placeholder="Enter New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>
</body>
</html>
