<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "construct";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get form data
$name = $_POST['name'];
$duration = $_POST['duration'];
$address = $_POST['address'];

// Insert into database
$sql = "INSERT INTO clients (name, duration, address, created_at) VALUES ('$name', '$duration', '$address', NOW())";

if ($connection->query($sql) === TRUE) {
    header("Location: project.php"); // Redirect back to the project page
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

$connection->close();
?>