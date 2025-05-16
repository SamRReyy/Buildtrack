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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $status = $_POST['status'];

    // Update the project's status in the database
    $stmt = $connection->prepare("UPDATE clients SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $project_id);
    $stmt->execute();

    // Fetch project details for the email
    $stmt = $connection->prepare("SELECT name, duration, address FROM clients WHERE id = ?");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();

    // Email details
    $to = "anothergamer.com@gmail.com"; // Replace with the recipient's email address
    $subject = "Project Status Updated: {$project['name']}";
    $message = "
        <h3>Project Status Updated</h3>
        <p><strong>Project Name:</strong> {$project['name']}</p>
        <p><strong>Duration:</strong> {$project['duration']}</p>
        <p><strong>Address:</strong> {$project['address']}</p>
        <p><strong>New Status:</strong> {$status}</p>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@constructstore.com";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully.";
    } else {
        echo "Failed to send email.";
    }

    // Redirect back to project.php
    header("Location: project.php");
    exit();
}
?>