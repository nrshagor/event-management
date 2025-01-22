<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/controllers/EventController.php';

header('Content-Type: application/json');

if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    $eventController = new EventController($pdo);
    $event = $eventController->getEventById($event_id);

    echo json_encode($event ? ['success' => true, 'event' => $event] : ['success' => false, 'message' => 'Event not found']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
