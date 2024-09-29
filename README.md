# E-Procurement System

## Overview
This is a Laravel-based E-Procurement system designed for managing vendor registrations, product catalogs, and other procurement processes.

## Prerequisites
- PHP (>= 8.0)
- Composer
- Node.js (with npm)
- Docker (if using Docker)
- MySQL or another database supported by Laravel

## Installation Instructions

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yustikodm/procurement.git
   cd procurement

2. **Install PHP Dependencies**
   ```bash
   composer install

3. **Install Install JavaScript Dependencies**
   ```bash
   npm install
4. **Copy the .env Example**
   ```bash
   cp .env.example .env
5. **Generate Application Key*
   ```bash
   php artisan key:generate

Set Up the Database

Create a new database in your database management system.
Update the database connection details in your .env file.

7. **Run Migrations**
   ```bash
   php artisan migrate

8. **Running the Application**
   ```bash
   php artisan serve
Access the application at http://localhost:8000.

Docker Setup (Optional)
Access the application at http://localhost:9000
If you want to run the application using Docker, follow these steps:
   ```bash
   docker-compose up --build




