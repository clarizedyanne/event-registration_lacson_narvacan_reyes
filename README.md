# ★ SVT Events – SEVENTEEN Event Registration System

A PHP and MySQL CRUD web application for managing fan registrations for SEVENTEEN concerts and events.

Built for **ITEL 203 – Web Systems and Technologies | Group Performance Task #2**

---

## Members
- Clarize Dyanne R. Reyes – Project Lead / Backend Developer
- Lea Chelsy K. Narvacan – Frontend Developer / UI Designer
- Jennifer P. Lacson – Deployment & Documentation

---

## Features
- Admin Login System
- Create, Read, Update, Delete (CRUD) registrations
- Manage concert events
- Search registrations by name, email, or ticket type
- Bootstrap 5 responsive UI
- Deployed on InfinityFree

---

## Technologies Used
- PHP (mysql)
- MySQL / phpMyAdmin / XAMPP
- HTML5, CSS3, Bootstrap 5
- Visual Studio Code
- GitHub
- InfinityFree

---

## How to Run Locally
1. Install XAMPP and start Apache + MySQL
2. Copy the project folder to `C:\xampp\htdocs\ITEL 203 - Laboratory Activity 5 (Groupings)`
3. Go to `http://localhost/phpmyadmin`
4. Create database: `db_seventeen`
5. Import `database.sql`
6. Open `http://localhost/ITEL%20203%20-%20Laboratory%20Activity%205%20(Groupings)/index.php`
7. Login with: **admin / admin123**

---

## Deployment Link
> https://svtevents-lacson-narvacan-reyes.ct.ws

---

## Project Structure
```
seventeen-crud/
├── config.php          # Database connection + session
├── login.php           # Admin login
├── logout.php          # Session logout
├── navbar.php          # Shared navigation
├── index.php           # Registrations list (main page)
├── create.php          # Add registration
├── update.php          # Edit registration
├── delete.php          # Delete registration
├── events.php          # Manage events
├── about-project.php   # About the project
├── developers.php      # About the developers
└── database.sql        # SQL file to set up the database
```
