<?php
$host = "localhost";  // Your database host
$dbname = "event_management";  // Your database name
$username = "root";  // Your database username
$password = "";  // Your database password (leave blank for localhost)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
