<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

if (!isset($_SESSION['user_id'])) {
    redirect('public/login.php');
}

$eventController = new EventController($pdo);

// Handle Event Deletion via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
    $eventId = intval($_POST['delete_event']);
    if ($eventController->deleteEvent($eventId)) {
        echo json_encode(["success" => true, "message" => "Event deleted successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting event."]);
    }
    exit;
}

// Fetch Events
$events = $eventController->getEvents();
?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<h2>Manage Your Events</h2>

<form id="eventForm" class="mb-4">
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
        <input type="datetime-local" name="date" id="date" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" class="form-control" placeholder="Location" required>
    </div>

    <div class="form-group">
        <label>Capacity</label>
        <input type="number" name="capacity" class="form-control" placeholder="Capacity" required min="1">
    </div>

    <button type="submit" class="btn btn-primary">Create Event</button>
</form>

<div id="responseMessage"></div>

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
    <tbody id="eventList">
        <?php foreach ($events as $event): ?>
            <tr id="event-<?= $event['id'] ?>">
                <td><?= htmlspecialchars($event['name']) ?></td>
                <td><?= htmlspecialchars($event['description']) ?></td>
                <td><?= htmlspecialchars($event['date']) ?></td>
                <td><?= htmlspecialchars($event['location']) ?></td>
                <td><?= htmlspecialchars($event['capacity']) ?></td>
                <td>
                    <a href="update_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-event" data-id="<?= $event['id'] ?>">Delete</button>
                    <a href="register_attendee.php?event_id=<?= $event['id'] ?>" class="btn btn-primary btn-sm">Register Attendees</a>
                    <a href="view_attendees.php?event_id=<?= $event['id'] ?>" class="btn btn-info btn-sm">View Attendees</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../app/views/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        const dateInput = $('#date');
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        const formattedDate = now.toISOString().slice(0, 16);
        dateInput.attr('min', formattedDate);

        // AJAX form submission
        $("#eventForm").submit(function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: 'ajax_create_event.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    $("#responseMessage").html('<div class="alert alert-info">Processing...</div>');
                },
                success: function(response) {
                    if (response.success) {
                        $("#responseMessage").html('<div class="alert alert-success">' + response.message + '</div>');
                        $("#eventForm")[0].reset();
                        loadEvents();
                    } else {
                        $("#responseMessage").html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function() {
                    $("#responseMessage").html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
                }
            });
        });

        // Function to reload event list without refreshing
        function loadEvents() {
            $.ajax({
                url: 'ajax_get_events.php',
                type: 'GET',
                success: function(data) {
                    $("#eventList").html(data);
                }
            });
        }

        // Handle event deletion
        $(document).on("click", ".delete-event", function() {
            let eventId = $(this).data('id');
            if (confirm("Are you sure you want to delete this event?")) {
                $.ajax({
                    url: 'events.php',
                    type: 'POST',
                    data: {
                        delete_event: eventId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $("#event-" + eventId).remove();
                            alert(response.message);
                        } else {
                            alert("Error: " + response.message);
                        }
                    }
                });
            }
        });
    });
</script>