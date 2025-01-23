# Event Management System

## Overview

The **Event Management System** is a web-based platform that allows users to create, manage, and view events. Users can register for events, and admins can download event attendee reports in CSV format.

## Features

### Core Features

- **User Authentication**
  - Secure login and registration with password hashing.
- **Event Management**
  - Create, update, view, and delete events.
- **Attendee Registration**
  - Register attendees with email verification and capacity check.
- **Event Dashboard**
  - View events with pagination, sorting, and search filters.
- **Event Reports**
  - Download attendee lists in CSV format.

### Additional Features

- **AJAX-based Event Registration** for a seamless user experience.
- **Search functionality** for events and attendees.
- **JSON API** endpoint to fetch event details.

## Technologies Used

- **Backend:** PHP (Pure PHP, no frameworks)
- **Database:** MySQL with PDO
- **Frontend:** HTML, Bootstrap, JavaScript, jQuery (AJAX)
- **Security:** Password hashing, input validation, prepared statements
- **Deployment:** Localhost (XAMPP/LAMP/WAMP) or online hosting

---

## Setup Instructions

### Prerequisites

Ensure you have the following installed:

- PHP (>=7.4)
- MySQL (>=5.7)
- Web Server (Apache or Nginx)
- Git (optional)

### Installation Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/yourusername/event-management-system.git
   cd event-management-system
   ```

   Set Up the Database

1. Create a database in MySQL named event_management.
   Import the provided SQL file located in database/event_management.sql using the following command:

```
mysql -u root -p event_management < event-management/database/event_management.sql
```

Configure Database Connection

Open the database/db.php file and update the following credentials if necessary:
php
Copy
Edit
$host = "localhost";
$dbname = "event_management";
$username = "root";
$password = "";
Run the Database Seeder

Seed the database with initial users and event data:
bash
Copy
Edit
php database/seed.php
Start the Server

If using XAMPP, move the project to htdocs and start Apache.
If using built-in PHP server, run:
bash
Copy
Edit
php -S localhost:8000
Access the Application

Open your browser and visit:
vbnet
Copy
Edit
http://localhost/event-management/public/login.php

Usage Instructions
Login Credentials
Super Admin (Full Access)
Email: admin@example.com
Password: admin123
Regular User
Email: user1@example.com
Password: password123
API Endpoints
The system provides a JSON API for event details.

GET Event Details:

vbnet
Copy
Edit
GET /public/api/event_details.php?event_id={event_id}
Example Response:

json
Copy
Edit
{
"success": true,
"event": {
"name": "Tech Conference",
"date": "2025-05-01 10:00:00",
"location": "Conference Hall",
"capacity": 200
}
}
Folder Structure
lua
Copy
Edit
event-management/
│-- app/
│ ├── config.php
│ ├── controllers/
│ ├── models/
│ ├── views/
│-- database/
│ ├── db.php
│ ├── seed.php
│-- public/
│ ├── login.php
│ ├── register.php
│ ├── dashboard.php
│ ├── events.php
│ ├── view_attendees.php
│ ├── export_attendees.php
│-- README.md
│-- .htaccess
Security Measures
Passwords are securely hashed using password_hash().
Prepared statements are used to prevent SQL injection.
Form validation is implemented to ensure data integrity.
Deployment Instructions
Choose a hosting service (e.g., Heroku, Vercel, or shared hosting).
Upload the project files via FTP or Git.
Configure the database on the hosting server.
Update the db.php file with the new database credentials.
Set the correct permissions for writable directories.
Share the live link with testers.
Contribution
If you'd like to contribute to this project, feel free to submit a pull request or report issues via GitHub.

License
This project is open-source and available under the MIT License.

Contact
If you have any questions, feel free to reach out:

Email: noorerabbishagor@gmail.com
GitHub: yourusername
yaml
Copy
Edit

---

### **Next Steps for You:**

1. Replace `https://github.com/yourusername/event-management-system.git` with your actual GitHub repository link.
2. Upload your project to a hosting service and provide the live link.
3. Add the `event_management.sql` file in your repository under the `database/` folder.
4. Double-check credentials and update any required values.

Let me know if you need help with hosting or anything else!
