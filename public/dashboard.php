<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

if (!isset($_SESSION['user_id'])) {
    redirect('public/login.php');
}

$eventController = new EventController();

// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
// Sorting and filtering
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';





// Get paginated events
$events = $eventController->getPaginatedEvents($limit, $offset, $sort, $search);
$totalEvents = $eventController->getTotalEventsCount($search);
$totalPages = ceil($totalEvents / $limit);
?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<div class="container mt-5">

    <h2>Event Dashboard</h2>
    <a href="dashboard.php" class="btn btn-secondary">Clear Search</a>

    <!-- Search Form -->
    <form method="GET" class="form-inline mb-4">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search events..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>


    <!-- Sorting Options -->
    <form method="GET" class="mb-4">
        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
        <label>Sort by:</label>
        <select name="sort" class="form-control d-inline w-auto" onchange="this.form.submit()">
            <option value="name" <?= $sort == 'name' ? 'selected' : '' ?>>Name</option>
            <option value="date" <?= $sort == 'date' ? 'selected' : '' ?>>Date</option>
            <option value="capacity" <?= $sort == 'capacity' ? 'selected' : '' ?>>Capacity</option>
        </select>
    </form>

    <!-- Event Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Location</th>
                <th>Capacity</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['description']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><?= htmlspecialchars($event['capacity']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No events found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&sort=<?= htmlspecialchars($sort) ?>&search=<?= urlencode($search) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

</div>


<?php include __DIR__ . '/../app/views/footer.php'; ?>