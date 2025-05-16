<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>login</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="assets/styles/bootstrap.min.css">
    <meta charset="utf-8">
    <style>
        .alert {
            border-radius: 8px;
            padding: 15px 20px;
            font-size: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .alert-danger {
            background-color: #ffebee;
            border-left: 5px solid #e53935;
            color: #c62828;
        }

        .alert-success {
            background-color: #e8f5e9;
            border-left: 5px solid #43a047;
            color: #2e7d32;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <img src="images/2.jpg" alt="This is the logo">
            
            <!--ALERTS-->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['success']; unset ($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['error']; unset ($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="code_validate.php" method="POST">
                <input type="code" placeholder="Enter code" name="code">
                <button type="Submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <?php if (isset($_SESSION['email_sent'])): ?>
        <script>
            alert("A code has been sent to your email.");
        </script>
        <?php unset($_SESSION['email_sent']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['code_verified'])): ?>
        <script>
            alert("Code verified successfully.");
        </script>
        <?php unset($_SESSION['code_verified']); ?>
    <?php endif; ?>
</body>

</html>