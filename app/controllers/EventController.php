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

    // Get Event Id
    public function getEventById($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ? AND created_by = ?");
        $stmt->execute([$id, $_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPaginatedEvents($limit, $offset, $sort, $search)
    {
        global $pdo;

        // Validate sorting fields to prevent SQL injection
        $allowedSortColumns = ['name', 'date', 'capacity'];
        $sort = in_array($sort, $allowedSortColumns) ? $sort : 'name';

        $query = "SELECT * FROM events WHERE created_by = ? ";
        $params = [$_SESSION['user_id']];

        if (!empty($search)) {
            $query .= "AND name LIKE ? ";
            $params[] = "%$search%";
        }

        // Append LIMIT and OFFSET directly for pagination
        $query .= "ORDER BY $sort LIMIT $limit OFFSET $offset";

        $stmt = $pdo->prepare($query);

        if (!empty($search)) {
            $stmt->execute([$params[0], $params[1]]);
        } else {
            $stmt->execute([$params[0]]);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getTotalEventsCount($search)
    {
        global $pdo;

        $query = "SELECT COUNT(*) FROM events WHERE created_by = ?";
        $params = [$_SESSION['user_id']];

        if (!empty($search)) {
            $query .= " AND name LIKE ?";
            $params[] = "%$search%";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }


    // Update Event Id

    public function updateEvent($id, $name, $description, $date, $location, $capacity)
    {
        global $pdo;

        $stmt = $pdo->prepare("UPDATE events SET name = ?, description = ?, date = ?, location = ?, capacity = ? 
                               WHERE id = ? AND created_by = ?");
        return $stmt->execute([$name, $description, $date, $location, $capacity, $id, $_SESSION['user_id']]);
    }


    // Delete an event
    public function deleteEvent($id)
    {
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ? AND created_by = ?");
        return $stmt->execute([$id, $_SESSION['user_id']]);
    }
}
