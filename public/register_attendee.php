<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/AttendeeController.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

$attendeeController = new AttendeeController();
$eventController = new EventController();
$events = $eventController->getEvents();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_attendee'])) {
    $event_id = intval($_POST['event_id']);
    $user_name = htmlspecialchars($_POST['user_name']);
    $email = htmlspecialchars($_POST['email']);

    $message = $attendeeController->registerAttendee($event_id, $user_name, $email);

    // Redirect to prevent form resubmission
    if ($message === "Registration successful!") {
        header("Location: register_attendee.php?success=1");
        exit;
    }
}
?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<h2>Register for an Event</h2>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">You have successfully registered!</div>
<?php elseif (!empty($message)): ?>
    <div class="alert alert-warning"><?= $message ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Select Event</label>
        <select name="event_id" class="form-control" required>
            <option value="">-- Select Event --</option>
            <?php foreach ($events as $event): ?>
                <option value="<?= $event['id'] ?>"><?= htmlspecialchars($event['name']) ?> (Capacity: <?= $event['capacity'] ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Your Name</label>
        <input type="text" name="user_name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Your Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit" name="register_attendee" class="btn btn-success">Register</button>
</form>

<?php include __DIR__ . '/../app/views/footer.php'; ?>