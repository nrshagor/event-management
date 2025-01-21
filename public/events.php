<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$eventController = new EventController();

// Handle event creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_event'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $location = htmlspecialchars($_POST['location']);
    $capacity = intval($_POST['capacity']);

    if ($eventController->createEvent($name, $description, $date, $location, $capacity)) {
        echo "<div class='alert alert-success'>Event created successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error creating event.</div>";
    }
}

// Handle event deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
    $eventId = intval($_POST['delete_event']);
    if ($eventController->deleteEvent($eventId)) {
        echo "<div class='alert alert-success'>Event deleted successfully!</div>";
        header("Location: events.php");
    } else {
        echo "<div class='alert alert-danger'>Error deleting event.</div>";
    }
}

// Fetch all events
$events = $eventController->getEvents();
?>
<?php include __DIR__ . '/../app/views/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Events</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Manage Your Events</h2>

        <form method="POST">
            <input type="text" name="name" class="form-control" placeholder="Event Name" required><br>
            <textarea name="description" class="form-control" placeholder="Event Description" required></textarea><br>
            <input type="datetime-local" name="date" class="form-control" required><br>
            <input type="text" name="location" class="form-control" placeholder="Location" required><br>
            <input type="number" name="capacity" class="form-control" placeholder="Capacity" required><br>
            <button type="submit" name="create_event" class="btn btn-primary">Create Event</button>
        </form>

        <h3 class="mt-5">Your Events</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']); ?></td>
                        <td><?= htmlspecialchars($event['description']); ?></td>
                        <td><?= htmlspecialchars($event['date']); ?></td>
                        <td><?= htmlspecialchars($event['location']); ?></td>
                        <td><?= htmlspecialchars($event['capacity']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="delete_event" value="<?= $event['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>

</html>
<?php include __DIR__ . '/../app/views/footer.php'; ?>