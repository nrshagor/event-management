<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    if ($auth->register($username, $email, $password)) {
        header("Location: login.php?success=1");
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Register</h2>
        <form action="" method="POST">
            <input type="text" name="username" class="form-control" placeholder="Username" required><br>
            <input type="email" name="email" class="form-control" placeholder="Email" required><br>
            <input type="password" name="password" class="form-control" placeholder="Password" required><br>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>

</html>