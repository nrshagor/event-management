<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/AttendeeController.php';

if (!isset($_GET['event_id'])) {
    echo "Invalid event.";
    exit;
}

$attendeeController = new AttendeeController();
$event_id = intval($_GET['event_id']);
$attendees = $attendeeController->getAttendeesByEvent($event_id);
?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<h2>Attendees List</h2>
<a href="export_attendees.php?event_id=<?= $event_id ?>" class="btn btn-success">Download CSV</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Registered At</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($attendees) > 0): ?>
            <?php foreach ($attendees as $attendee): ?>
                <tr>
                    <td><?= htmlspecialchars($attendee['user_name']) ?></td>
                    <td><?= htmlspecialchars($attendee['email']) ?></td>
                    <td><?= htmlspecialchars($attendee['registered_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No attendees registered.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../app/views/footer.php'; ?>