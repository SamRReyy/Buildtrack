<?php

$servername = "localhost";
$usernmae = "root";
$password = "";
$dbname = "construct";

$conn = new mysqli ($servername, $usernmae, $password, $dbname);

try{
    $pdo = new PDO("mysql:host=$servername; dbname=$dbname", $usernmae, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOxception $e) {
    die ("Database Connection Failed:" . $e->getMessage());
}



?>