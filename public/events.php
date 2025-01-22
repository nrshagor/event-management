<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

if (!isset($_SESSION['user_id'])) {
    redirect('public/login.php');
}

$eventController = new EventController($pdo);

// Handle Event Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_event'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $location = htmlspecialchars($_POST['location']);
    $capacity = intval($_POST['capacity']);

    if ($eventController->createEvent($name, $description, $date, $location, $capacity)) {
        // Redirect to prevent form resubmission
        header("Location: events.php?success=1");
        exit;
    } else {
        echo "Error creating event.";
    }
}

// Handle Event Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
    $eventId = intval($_POST['delete_event']);
    if ($eventController->deleteEvent($eventId)) {
        // Redirect to prevent duplicate deletion
        header("Location: events.php?deleted=1");
        exit;
    } else {
        echo "Error deleting event.";
    }
}

// Fetch Events
$events = $eventController->getEvents();
?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<!-- Success messages -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Event created successfully!</div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-warning">Event deleted successfully!</div>
<?php endif; ?>

<h2>Manage Your Events</h2>
<form method="POST" class="mb-4">
    <div class="form-group">
        <label>Event Name</label>
        <input type="text" name="name" class="form-control" placeholder="Event Name" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" placeholder="Event Description" required></textarea>
    </div>
    <div class="form-group">
        <label>Date</label>
        <input type="datetime-local" name="date" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" class="form-control" placeholder="Location" required>
    </div>
    <div class="form-group">
        <label>Capacity</label>
        <input type="number" name="capacity" class="form-control" placeholder="Capacity" required>
    </div>
    <button type="submit" name="create_event" class="btn btn-primary">Create Event</button>
</form>

<h3>Your Events</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['name']) ?></td>
                    <td><?= htmlspecialchars($event['description']) ?></td>
                    <td><?= htmlspecialchars($event['date']) ?></td>
                    <td><?= htmlspecialchars($event['location']) ?></td>
                    <td><?= htmlspecialchars($event['capacity']) ?></td>
                    <td>
                        <a href="update_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="delete_event" value="<?= $event['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="register_attendee.php" class="btn btn-primary btn-sm">Register Attendees</a>
                        <a href="view_attendees.php?event_id=<?= $event['id'] ?>" class="btn btn-info btn-sm">View Attendees</a>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No events found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../app/views/footer.php'; ?>