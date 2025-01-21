<?php
session_start();

require_once __DIR__ . '/../database/db.php';

// Define base URL
define('BASE_URL', 'http://localhost/event-management/');

// Utility function to redirect
function redirect($url)
{
    header("Location: " . BASE_URL . $url);
    exit;
}
