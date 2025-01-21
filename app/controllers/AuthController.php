<?php
require_once __DIR__ . '/../config.php';

class AuthController
{
    public function register($username, $email, $password)
    {
        global $pdo;

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        if ($stmt->execute([$username, $email, $hashedPassword])) {
            return true;
        }
        return false;
    }

    public function login($email, $password)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
        redirect('public/login.php');
    }
}
