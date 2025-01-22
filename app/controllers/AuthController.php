<?php
require_once __DIR__ . '/../config.php';

class AuthController
{
    public function register($username, $email, $password)
    {
        global $pdo;

        // Default role assigned as 'user'
        $role = 'user';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");

        if ($stmt->execute([$username, $email, $hashedPassword, $role])) {
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
            $_SESSION['role'] = $user['role'];  // Store role in session

            return true;
        }
        return false;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: public/login.php");
        exit;
    }
}
