<?php
require_once __DIR__ . '/../config.php';

class EventController
{
    // Create a new event
    public function createEvent($name, $description, $date, $location, $capacity)
    {
        global $pdo;

        $stmt = $pdo->prepare("INSERT INTO events (name, description, date, location, capacity, created_by) VALUES (?, ?, ?, ?, ?, ?)");

        return $stmt->execute([$name, $description, $date, $location, $capacity, $_SESSION['user_id']]);
    }

    // Get all events for the logged-in user
    public function getEvents()
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM events WHERE created_by = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete an event
    public function deleteEvent($id)
    {
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ? AND created_by = ?");
        return $stmt->execute([$id, $_SESSION['user_id']]);
    }
}
