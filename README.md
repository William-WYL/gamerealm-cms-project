Game Realm CMS

Game Realm is a full-stack web application built with PHP and JavaScript, serving as a content management system for gaming content with features like user authentication, content management, and responsive design.

🎯 Project Focus
This project demonstrates:
✅ PHP backend development with MySQL database
✅ Frontend interactivity with vanilla JavaScript
✅ Bootstrap (v5) for responsive UI components
✅ Full CRUD operations for content management
✅ User authentication system

🛠️ Tech Stack

Core Technologies:

    PHP (^8.0) for server-side logic

    MySQL for database management

    JavaScript for client-side interactivity

    Bootstrap (^5.2.3) for responsive styling

    HTML5 & CSS3 for structure and presentation

Key Dependencies:

    PDO for secure database connections

    Bootstrap Icons for UI elements

    jQuery (optional, if used in your project)


✨ Key Features

🔹 User Authentication System
🔹 Content Management Dashboard
🔹 Database-driven Dynamic Content
🔹 Responsive Layout with Bootstrap
🔹 Form Validation (Client & Server-side)
🗃️ Database Setup

This project includes a database.sql file containing the schema and sample data.

How to set up:

    Create a new MySQL database:

sql

CREATE DATABASE gamerealm;

    Import the database file: database\database.sql

bash

mysql -u your_username -p gamerealm < database.sql

(Or use phpMyAdmin/MySQL Workbench to import the SQL file)

    Update your database credentials in the configuration file:

php

// config.php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'gamerealm');