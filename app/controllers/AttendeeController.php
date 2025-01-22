<?php
require_once __DIR__ . '/../config.php';

class AttendeeController
{
    public function registerAttendee($event_id, $user_name, $email)
    {
        global $pdo;

        // Check current number of attendees registered for the event
        $stmt = $pdo->prepare("
            SELECT 
                (SELECT COUNT(*) FROM attendees WHERE event_id = ?) AS total_registered, 
                (SELECT capacity FROM events WHERE id = ?) AS capacity
        ");
        $stmt->execute([$event_id, $event_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['total_registered'] >= $result['capacity']) {
            return "Event is fully booked.";
        }

        // Check for duplicate email registration for the same event
        $stmt = $pdo->prepare("SELECT id FROM attendees WHERE event_id = ? AND email = ?");
        $stmt->execute([$event_id, $email]);
        if ($stmt->fetch()) {
            return "You are already registered for this event.";
        }

        // Insert new attendee
        $stmt = $pdo->prepare("INSERT INTO attendees (event_id, user_name, email) VALUES (?, ?, ?)");
        if ($stmt->execute([$event_id, $user_name, $email])) {
            return "Registration successful!";
        }

        return "Registration failed. Please try again.";
    }

    public function getAttendeesByEvent($event_id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT user_name, email, registered_at FROM attendees WHERE event_id = ?");
        $stmt->execute([$event_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
