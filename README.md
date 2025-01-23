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
