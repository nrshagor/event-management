<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

$eventController = new EventController($pdo);
$events = $eventController->getEvents();

foreach ($events as $event): ?>
    <tr>
        <td><?= htmlspecialchars($event['name']) ?></td>
        <td><?= htmlspecialchars($event['description']) ?></td>
        <td><?= htmlspecialchars($event['date']) ?></td>
        <td><?= htmlspecialchars($event['location']) ?></td>
        <td><?= htmlspecialchars($event['capacity']) ?></td>
        <td>
            <button class="btn btn-danger btn-sm delete-event" data-id="<?= $event['id'] ?>">Delete</button>
        </td>
    </tr>
<?php endforeach; ?>