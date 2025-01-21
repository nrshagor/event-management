<?php
require_once __DIR__ . '/../app/config.php';
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}
?>

<?php include __DIR__ . '/../app/views/header.php'; ?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
<p>This is your dashboard where you can manage your events.</p>

<a href="events.php" class="btn btn-primary">Manage Events</a>

<?php include __DIR__ . '/../app/views/footer.php'; ?>