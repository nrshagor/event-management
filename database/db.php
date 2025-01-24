<?php
$host = "localhost";  // Your database host
$dbname = "event_management";  // Your database name
$username = "root";  // Your database username
$password = "";  // Your database password (leave blank for localhost)


// $host = "127.0.0.1";  // Your database host
// $dbname = "codenr5_event_management";  // Your database name
// $username = "codenr5_event_management";  // Your database username
// $password = "j!=asLkaQZ&y";  // Your database password (leave blank for localhost)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
