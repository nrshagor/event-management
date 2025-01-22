<?php
require_once __DIR__ . '/../models/Attendee.php';

class AttendeeController
{
    private $attendeeModel;

    public function __construct($pdo)
    {
        $this->attendeeModel = new AttendeeModel($pdo);
    }

    public function registerAttendee($event_id, $user_name, $email)
    {
        // Validate input fields
        if (empty($event_id) || empty($user_name) || empty($email)) {
            return "All fields are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        // Check event capacity
        $eventDetails = $this->attendeeModel->getEventDetails($event_id);
        if (!$eventDetails) {
            return "Event not found.";
        }

        if ($eventDetails['total_registered'] >= $eventDetails['capacity']) {
            return "Event is fully booked.";
        }

        // Check duplicate email registration
        if ($this->attendeeModel->checkIfEmailExists($event_id, $email)) {
            return "You are already registered for this event.";
        }

        // Register attendee
        if ($this->attendeeModel->addAttendee($event_id, $user_name, $email)) {
            return "Registration successful!";
        }

        return "Registration failed. Please try again.";
    }

    public function listAttendees($event_id)
    {
        if (empty($event_id)) {
            return "Event ID is required.";
        }

        $attendees = $this->attendeeModel->getAttendeesByEvent($event_id);
        return $attendees ?: "No attendees found for this event.";
    }
}
