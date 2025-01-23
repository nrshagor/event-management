<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fa;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            font-size: 1.1rem;
            margin-right: 15px;
        }

        .btn-primary,
        .btn-danger {
            font-weight: 600;
            border-radius: 50px;
            padding: 8px 20px;
        }


        h2 {
            font-weight: 600;
        }

        .table th {
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .pagination .page-link {
            /* border-radius: 30px; */
            margin-left: 2px;
            padding: 8px 16px;
            font-weight: bold;
        }

        .btn-primary {
            border-radius: 25px;
            padding: 10px 24px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= BASE_URL ?>">Event Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>public/dashboard.php">Dashboard</a></li>

                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'super_admin')): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>public/events.php">Manage Events</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'super_admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>public/manage_users.php">Manage Users</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link btn btn-danger" href="<?= BASE_URL ?>public/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link btn btn-primary" href="<?= BASE_URL ?>public/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">