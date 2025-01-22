<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/AttendeeController.php';

if (!isset($_GET['event_id'])) {
    die("Invalid event ID.");
}

$event_id = intval($_GET['event_id']);
$attendeeController = new AttendeeController();
$attendees = $attendeeController->getAttendeesByEvent($event_id);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendees_event_' . $event_id . '.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Name', 'Email', 'Registered At']);

foreach ($attendees as $attendee) {
    fputcsv($output, [$attendee['user_name'], $attendee['email'], $attendee['registered_at']]);
}

fclose($output);
exit;
