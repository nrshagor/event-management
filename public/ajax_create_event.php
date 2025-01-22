<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

$eventController = new EventController($pdo);

$name = htmlspecialchars($_POST['name']);
$description = htmlspecialchars($_POST['description']);
$date = $_POST['date'];
$location = htmlspecialchars($_POST['location']);
$capacity = intval($_POST['capacity']);

// Server-side date validation to prevent past events
$currentDateTime = date('Y-m-d\TH:i');

if ($date < $currentDateTime) {
    echo json_encode(["success" => false, "message" => "Event date cannot be in the past."]);
} else {
    if ($eventController->createEvent($name, $description, $date, $location, $capacity)) {
        echo json_encode(["success" => true, "message" => "Event created successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error creating event."]);
    }
}
