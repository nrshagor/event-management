<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

if (!isset($_SESSION['user_id'])) {
    redirect('public/login.php');
}

// Get event ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid Event ID.";
    exit;
}

$eventId = intval($_GET['id']);
$eventController = new EventController($pdo);
$event = $eventController->getEventById($eventId);

if (!$event) {
    echo "Event not found.";
    exit;
}
?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<h2>Update Event</h2>
<div id="message"></div>

<form id="updateEventForm" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="event_id" value="<?= $eventId ?>">

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

    <div class="form-group">
        <label>Event Image</label><br>
        <img id="eventImage" src="<?= BASE_URL ?>public/uploads/<?= $event['image'] ?>" alt="Current Event Image" width="150"><br>
        <input type="file" name="event_image" class="form-control">
        <small class="text-muted">Leave empty to keep current image. Max size 5MB, allowed types: JPG, JPEG, PNG.</small>
    </div>

    <button type="submit" class="btn btn-primary">Update Event</button>
    <a href="events.php" class="btn btn-secondary">Cancel</a>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("#updateEventForm").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: 'ajax_update_event.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $("#message").html('<div class="alert alert-info">Updating...</div>');
                    $("button[type='submit']").prop("disabled", true).text('Updating...');
                },
                success: function(response) {
                    $("button[type='submit']").prop("disabled", false).text('Update Event');

                    if (response.success) {
                        $("#message").html('<div class="alert alert-success">' + response.message + '</div>');

                        $("input[name='name']").val(response.data.name);
                        $("textarea[name='description']").val(response.data.description);
                        $("input[name='date']").val(response.data.date);
                        $("input[name='location']").val(response.data.location);
                        $("input[name='capacity']").val(response.data.capacity);
                        $("img#eventImage").attr('src', response.image_url);
                    } else {
                        $("#message").html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $("button[type='submit']").prop("disabled", false).text('Update Event');
                    $("#message").html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
                }
            });
        });
    });
</script>

<?php include __DIR__ . '/../app/views/footer.php'; ?>