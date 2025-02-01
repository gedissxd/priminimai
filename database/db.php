<?php
/**
 * Database configuration and connection setup
 */

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "priminimai";

// Create connection with error handling
try {
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        throw new Exception(mysqli_connect_error());
    }

    // Set charset to ensure proper encoding
    mysqli_set_charset($conn, "utf8mb4");
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}