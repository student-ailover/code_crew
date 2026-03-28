<?php

// Database credentials
$host = "localhost";
$db   = "code_crew"; // Your database name
$user = "root";      // Use your MariaDB username (often 'root' on Arch)
$pass = "";          // Use your MariaDB password
$charset = 'utf8mb4';

// Data Source Name (DSN) defines the connection details
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Set PDO options for security and usability
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throws errors as exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Results as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
    // Create the connection object
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // If connection fails, stop and log the error
    // In a production environment, don't echo $e->getMessage() to users
    die("Connection failed: " . $e->getMessage());
}
?>