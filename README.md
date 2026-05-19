# Student Course Registration Portal

**CSC 442 — PHP & MySQL**  
**Student:** Elijah  
**Live URL:** https://studentportal.elijahu.me  
**Repository:** https://github.com/elijahu1/student-portal

---

## Overview

A web-based student course registration system built with PHP and MySQL. Students can browse and register for courses, while administrators manage the course catalogue and view registrations.

---

## Features

**Students**
- Register and log in securely
- Browse available courses with live search
- Register for or drop courses
- View enrolled courses and total credits on dashboard
- Credit limit of 18 per semester enforced automatically

**Admins**
- Create, edit, and delete courses
- View all student registrations
- Export registrations as CSV
- View all registered users

---

## Technologies Used

- PHP 8.3 (no frameworks)
- MySQL / MariaDB
- HTML & CSS (no frontend frameworks)
- Nginx web server
- Docker & Docker Compose
- Traefik reverse proxy with HTTPS

---

## Database Design

Three tables:

**users** — stores student and admin accounts  
**courses** — stores course information including capacity and enrolled count  
**registrations** — join table linking students to courses (many-to-many)

---

## How to Run Locally

### Requirements
- PHP 8+ with `pdo_mysql` extension
- MariaDB or MySQL

### Steps

```bash
# Clone the repo
git clone https://github.com/elijahu1/student-portal.git
cd student-portal

# Import the database
mysql -u root -p < database/schema.sql

# Start the development server
php -S localhost:8080 -t public/
```

Visit `http://localhost:8080`

**Default admin login:**
- Email: `admin@portal.dev`
- Password: `password`

---

## Project Structure

```
student-portal/
├── database/schema.sql       # Database schema and seed data
├── public/                   # Web root (entry point for browser)
│   ├── css/app.css           # Stylesheet
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php         # Student dashboard
│   ├── courses.php           # Course catalogue
│   └── admin/                # Admin-only pages
├── src/
│   ├── config/               # Database connection and bootstrap
│   ├── models/               # User, Course, Registration
│   └── controllers/          # Auth, Course, Admin logic
└── views/layout/             # Shared header and footer
```

---

## Security

- Passwords hashed with bcrypt
- PDO prepared statements to prevent SQL injection
- Output escaped with `htmlspecialchars()` to prevent XSS
- Role-based access control for admin pages
- HTTPS enforced in production
