# Restaurant Manager

<details>

<summary><b>Table contents</b></summary>

- [Restaurant Manager](#restaurant-manager)
  - [Description](#description)
  - [Features](#features)
  - [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
  - [Folder Structure](#folder-structure)

</details>

## Description

Restaurant Manager is a web application designed to streamline and simplify the management of restaurants. Built with Laravel, it provides an intuitive interface for handling menus, orders, users, and more.

## Features

-   User authentication and profile management
-   Menu and item management
-   Order tracking (current and previous orders)
-   Responsive dashboard for administrators and staff
-   API endpoints for menu, user, and order operations
-   Modern UI with Tailwind CSS and Alpine.js

## Getting Started

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & npm

### Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/CristianManuelAlcobendasBeorlegui/restaurant-manager.git
    cd restaurant-manager
    ```

2. **Install PHP dependencies:**

    ```sh
    composer install
    ```

3. **Install JavaScript dependencies:**

    ```sh
    npm install
    ```

4. **Copy the example environment file and configure:**

    ```sh
    cp .env.example .env
    ```

    Edit `.env` to set your database and application configuration.

5. **Generate application key:**

    ```sh
    php artisan key:generate
    ```

6. **Run migrations:**

    ```sh
    php artisan migrate --seed
    ```

7. **Build frontend assets:**

    ```sh
    npm run build
    ```

    For development, use `npm run dev`.

8. **Start the development server:**
    ```sh
    php artisan serve
    ```

Visit [http://localhost:8000](http://localhost:8000) to access the application.

Visit [http://localhost:8000/login](http://localhost:8000/login) to access admin dashboard.

**Credentials**

- `user`: admin@example.com
- `password`: adminadmin

## Folder Structure

-   `app/` - Application logic (models, controllers, etc.)
-   `resources/views/` - Blade templates for the UI
-   `public/` - Public assets and entry point
-   `routes/` - Route definitions
-   `config/` - Configuration files
