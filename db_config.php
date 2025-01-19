<?php
// db_config.php

// Database Configuration
$host = 'localhost';           // Host name (e.g., localhost)
$dbname = 'db_project'; // Replace with your database name
$username = 'root';    // Replace with your database username
$password = '';    // Replace with your database password

try {
    // Establishing Database Connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set Error Mode to Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle Connection Errors
    die("Database connection failed: " . $e->getMessage());
}
