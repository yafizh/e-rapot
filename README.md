# E-Rapot: Digital School Management & Grading System

A web-based E-Learning and digital report card management system built with PHP and MySQL. Designed to streamline administrative tasks for admins, teachers, and students.

## Features

- **Multi-Role Access**: Dedicated dashboards for Admin, Guru (Teacher), and Siswa (Student).
- **Academic Management**: Manage classes, subjects, semesters, and academic years.
- **Grading System**: Input and calculate student grades automatically.
- **Attendance Tracking**: Record daily attendance for students and teachers.
- **Digital Library**: Upload and access digital books and learning materials.
- **Report Generation**: Generate and print official report cards.

## Prerequisites

- **Web Server**: Apache / Nginx (XAMPP recommended for local development).
- **PHP**: Version 7.4 or higher.
- **Database**: MySQL / MariaDB.

## Installation Guide

Follow these steps to set up the project locally:

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/yafizh/e-rapot.git
    ```

2.  **Configure Database**
    -   Create a new database named `db_e_rapot` in phpMyAdmin or your MySQL client.
    -   Import the schema file: `db/database.sql`.
    -   Import the initial data: `db/seeder.sql` (This creates default users).

3.  **Configure Connection**
    -   Open `db/koneksi.php` and verify your database credentials (default is usually `root` with no password for XAMPP).

4.  **Run the Application**
    -   Move the project folder to `htdocs` (if using XAMPP).
    -   Access via browser: `http://localhost/e-rapot`.

## Default Access Credentials

Use the following accounts to log in and test the system:

### Administrator
-   **Username**: `admin`
-   **Password**: `admin`

### Guru (Teacher)
-   **NIP**: `196910291995031002`
-   **Password**: `196910291995031002`

### Siswa (Student)
-   **NIS**: `131262130001160477`
-   **Password**: `131262130001160477`

> **Note**: Passwords for teachers and students default to their NIP (Employee ID) and NIS (Student ID) respectively.

## Directory Structure

-   `assets/`: CSS, JS, Images.
-   `db/`: Database files (`database.sql`, `seeder.sql`).
-   `functions/`: Helper functions.
-   `halaman/`: View files separated by role/feature (admin, guru, siswa).
-   `templates/`: Reusable components (header, sidebar).