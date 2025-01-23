<?php
require_once __DIR__ . '/../models/Event.php';

class EventController
{
    private $eventModel;

    public function __construct($pdo)
    {
        $this->eventModel = new EventModel($pdo);
    }

    public function createEvent($name, $description, $date, $location, $capacity)
    {
        if (empty($name) || empty($date) || empty($location) || empty($capacity)) {
            return "All fields are required.";
        }

        if (!isset($_SESSION['user_id'])) {
            return "Unauthorized access.";
        }

        $user_id = $_SESSION['user_id'];
        if ($this->eventModel->createEvent($name, $description, $date, $location, $capacity, $user_id)) {
            return "Event created successfully!";
        }

        return "Failed to create event.";
    }

    // public function getEvents()
    // {
    //     if (!isset($_SESSION['user_id'])) {
    //         return "Unauthorized access.";
    //     }

    //     $user_id = $_SESSION['user_id'];
    //     return $this->eventModel->getEvents($user_id);
    // }
    public function getEvents()
    {
        // Allow access to events even if not logged in
        return $this->eventModel->getAllEvents();
    }

    public function getEventById($id)
    {
        if (!isset($_SESSION['user_id'])) {
            return "Unauthorized access.";
        }

        $user_id = $_SESSION['user_id'];
        return $this->eventModel->getEventById($id, $user_id);
    }

    public function getPaginatedEvents($limit, $offset, $sort, $search)
    {
        if (!isset($_SESSION['user_id'])) {
            return "Unauthorized access.";
        }

        $user_id = $_SESSION['user_id'];
        return $this->eventModel->getPaginatedEvents($user_id, $limit, $offset, $sort, $search);
    }

    public function getTotalEventsCount($search)
    {
        if (!isset($_SESSION['user_id'])) {
            return "Unauthorized access.";
        }

        $user_id = $_SESSION['user_id'];
        return $this->eventModel->getTotalEventsCount($user_id, $search);
    }

    public function updateEvent($id, $name, $description, $date, $location, $capacity)
    {
        if (!isset($_SESSION['user_id'])) {
            return "Unauthorized access.";
        }

        $user_id = $_SESSION['user_id'];
        if ($this->eventModel->updateEvent($id, $name, $description, $date, $location, $capacity, $user_id)) {
            return "Event updated successfully!";
        }

        return "Failed to update event.";
    }

    public function deleteEvent($id)
    {
        if (!isset($_SESSION['user_id'])) {
            return "Unauthorized access.";
        }

        $user_id = $_SESSION['user_id'];
        if ($this->eventModel->deleteEvent($id, $user_id)) {
            return "Event deleted successfully!";
        }

        return "Failed to delete event.";
    }
}
