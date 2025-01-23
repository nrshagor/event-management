<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

header('Content-Type: application/json');

try {
    $eventController = new EventController($pdo);

    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $location = htmlspecialchars($_POST['location']);
    $capacity = intval($_POST['capacity']);

    // Server-side date validation
    $currentDateTime = date('Y-m-d\TH:i');
    if ($date < $currentDateTime) {
        echo json_encode(["success" => false, "message" => "Event date cannot be in the past."]);
        exit;
    }

    if ($eventController->createEvent($name, $description, $date, $location, $capacity)) {
        $newEventId = $pdo->lastInsertId();

        echo json_encode([
            "success" => true,
            "message" => "Event created successfully!",
            "html" => '<tr id="event-' . $newEventId . '">
                            <td>' . htmlspecialchars($name) . '</td>
                            <td>' . htmlspecialchars($description) . '</td>
                            <td>' . htmlspecialchars($date) . '</td>
                            <td>' . htmlspecialchars($location) . '</td>
                            <td>' . htmlspecialchars($capacity) . '</td>
                            <td>
                                <a href="update_event.php?id=' . $newEventId . '" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm delete-event" data-id="' . $newEventId . '">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <a href="register_attendee.php?event_id=' . $newEventId . '" class="btn btn-primary btn-sm">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                                <a href="view_attendees.php?event_id=' . $newEventId . '" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                       </tr>'
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Error creating event."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Exception: " . $e->getMessage()]);
}
