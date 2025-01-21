<?php
require_once(__DIR__ . '/db.php'); // Ensure correct path

try {
    $pdo->exec("
        INSERT INTO users (username, email, password) VALUES 
        ('admin', 'admin@example.com', '" . password_hash('admin123', PASSWORD_BCRYPT) . "'),
        ('user1', 'user1@example.com', '" . password_hash('password123', PASSWORD_BCRYPT) . "');
        
        INSERT INTO events (name, description, date, location, capacity, created_by) VALUES 
        ('Tech Conference', 'Annual tech meet', '2025-05-01 10:00:00', 'Conference Hall', 200, 1),
        ('Music Festival', 'Enjoy live music performances', '2025-06-15 18:00:00', 'City Park', 500, 1);
    ");

    echo "Database seeded successfully!";
} catch (PDOException $e) {
    die("Error seeding database: " . $e->getMessage());
}
