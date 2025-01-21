INSERT INTO users (username, email, password)
VALUES 
('admin', 'admin@example.com', '$2y$10$e.ImkqUslBGRp5MJSZT3quZB8xtfOrrXjXae0ZZ6rBB15Q4HAYV9O'); -- Password: admin123

INSERT INTO events (name, description, date, location, capacity, created_by)
VALUES 
('Tech Conference', 'Annual tech meet', '2025-05-01 10:00:00', 'Conference Hall', 200, 1);
