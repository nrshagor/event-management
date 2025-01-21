<?php
require_once __DIR__ . '/../app/config.php';

if (!isset($_SESSION['user_id'])) {
    redirect('public/login.php');
}

echo "<h1>Welcome, " . $_SESSION['username'] . "!</h1>";
echo "<a href='logout.php'>Logout</a>";
