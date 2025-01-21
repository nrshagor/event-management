<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        header("Location: dashboard.php");
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="email" name="email" class="form-control" placeholder="Email" required><br>
            <input type="password" name="password" class="form-control" placeholder="Password" required><br>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>