<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

if (!isset($_SESSION['user_id'])) {
    redirect('public/login.php');
}

$eventController = new EventController();

// Get event ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid Event ID";
    exit;
}

$eventId = intval($_GET['id']);
$event = $eventController->getEventById($eventId);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_event'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $location = htmlspecialchars($_POST['location']);
    $capacity = intval($_POST['capacity']);

    if ($eventController->updateEvent($eventId, $name, $description, $date, $location, $capacity)) {
        header("Location: events.php?updated=1");
        exit;
    } else {
        echo "Error updating event.";
    }
}

?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<h2>Update Event</h2>
<form method="POST">
    <div class="form-group">
        <label>Event Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($event['name']) ?>" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" required><?= htmlspecialchars($event['description']) ?></textarea>
    </div>
    <div class="form-group">
        <label>Date</label>
        <input type="datetime-local" name="date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($event['date'])) ?>" required>
    </div>
    <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($event['location']) ?>" required>
    </div>
    <div class="form-group">
        <label>Capacity</label>
        <input type="number" name="capacity" class="form-control" value="<?= $event['capacity'] ?>" required>
    </div>
    <button type="submit" name="update_event" class="btn btn-primary">Update Event</button>
    <a href="events.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include __DIR__ . '/../app/views/footer.php'; ?>