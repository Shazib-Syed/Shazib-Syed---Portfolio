# Portfolio Website

## Table of Contents

- [Portfolio Website](#portfolio-website)
  - [Table of Contents](#table-of-contents)
  - [Introduction](#introduction)
  - [Features](#features)
  - [Technologies Used](#technologies-used)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Folder Structure](#folder-structure)
  - [Database Setup](#database-setup)
  - [Contributing](#contributing)
  - [License](#license)

## Introduction

This project is a personal portfolio and CMS-based web application built with PHP and Tailwind CSS. It allows users to view my projects on the website and gives me the ability to manage content via a CMS.

## Features

- **CMS Dashboard**: Add, edit, or delete projects with ease.
- **Content Submission**: Content forms is stored and managed in an SQL database.
- **Responsive Design**: Optimized for several screen sizes.

## Technologies Used

- **PHP**
- **SQL**
- **Tailwind CSS**
- **Node.js**
- **PostCSS**

## Installation

To set up the project locally, follow these steps:

1. **Clone the Repository**:

    ```bash
    git clone git@github.com:Shazib-Syed/Shazib-Syed---Portfolio.git
    cd to project
    ```

2. **Install Node.js Dependencies**:
   Make sure Node.js is installed. If not, download and install it, then run:

    ```bash
    npm install
    ```

3. **Build the CSS**:
   After installing, build the Tailwind CSS file:

    ```bash
    npm run build:css
    ```

4. **Set Up Your Web Server**:
    - Use a local server like XAMPP or the built-in PHP server.
    - Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).
    - Access the project in your browser at `http://localhost/yourproject`.

## Usage

After installation, follow these instructions to use the project:

- **Access the Admin Dashboard**: Go to `/cms_login.php`.
- **Credentials**: Default username is `admin` and password is `password`.

## Folder Structure

Here’s an overview of the project folder structure:

```
project-root/
│
├── CMS/                     # CMS-related files
│   ├── uploads/             # Folder for uploads
│   ├── cms_add_project.php
│   ├── cms_dashboard.php
│   ├── cms_delete_project.php
│   ├── cms_edit_project.php
│   ├── cms_login.php
│   ├── logout.php
│
├── config/                  # Configuration files
│   └── config.php
│
├── database/                # Database scripts
│   └── database.sql
│
├── IMG/                     # Image files
│   └── IMG1/
│
├── get_projects.php
├── index.php                # Main entry point
└── submit_form.php          # Form submission handling
```

## Database Setup

Before running the project, the database must be set up. Follow these steps:

1. **Create the Database**:

    ```sql
    CREATE DATABASE portfolioproject;
    USE portfolioproject;
    ```

2. **Create the Necessary Tables**:

    Run the following SQL commands to set up the required tables:

    ```sql
    CREATE TABLE projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(255) NOT NULL,
        live_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ```

3. **Configure Database Credentials**:
   In `config/config.php`, set up your database connection details:

    ```php
    <?php
    $host = 'localhost';
    $dbname = 'portfolioproject'; 
    $username = 'your_username'; // Replace with your database username
    $password = 'your_password'; // Replace with your database password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
    ?>
    ```

## Contributing

Contributions to this project are welcome! If you have suggestions or encounter issues, please open an issue or submit a pull request with your proposed changes.

## License

This project is licensed under the [MIT License](LICENSE). For more details, see the [LICENSE](LICENSE) file. 
