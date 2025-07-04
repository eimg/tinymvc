# TinyMVC

A lightweight, zero-dependency PHP micro-framework, modernized for PHP 8+. TinyMVC is designed to quickly bootstrap web applications with a simple, intuitive, and secure structure. It retains its original simplicity while adopting modern PHP features and best practices.

## Features

- **PHP 8+ Ready:** Built with a modern, object-oriented architecture using strict typing.
- **Composer Inside:** Leverages Composer for PSR-4 autoloading, making class management seamless.
- **Secure by Design:** Uses a `public/` directory as the web root, ensuring that sensitive application files are not directly accessible.
- **Simple File-Based Routing:** Routes are cleanly defined in a single, easy-to-manage `src/routes.php` file.
- **Basic MVC Pattern:** A straightforward implementation of the Model-View-Controller pattern.
- **Simple Templating:** Includes a basic layout system to keep your views DRY (Don't Repeat Yourself).
- **Zero Dependencies:** The core framework has no external dependencies.

## Requirements

- PHP 8.0 or higher
- Composer

## Installation & Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/eimg/tinymvc.git
    cd tinymvc
    ```

2.  **Install dependencies:**
    (This will only install the Composer autoloader, as there are no external packages.)
    ```bash
    composer install
    ```

3.  **Configuration (Optional):**
    Database settings are located in `src/config.php`. The project comes pre-configured to use a SQLite database, which requires no setup. If you wish to use MySQL, you can update the configuration accordingly.

## Running the Application

The project includes a convenient script to start a local development server.

```bash
composer start
```

The application will be available at `http://localhost:8000`.

## Project Structure

The modernized structure is simple and organized:

```
.
├── public/             # Web server root, contains index.php and static assets
│   ├── css/
│   ├── js/
│   └── index.php
├── src/                # Main application code
│   ├── Controllers/    # Handles user requests and business logic
│   ├── Core/           # Core framework classes (Application, Router, etc.)
│   ├── Models/         # Handles database interaction
│   ├── Views/          # Contains presentation files (HTML templates)
│   │   └── layouts/
│   ├── config.php      # Application configuration
│   └── routes.php      # Route definitions
├── vendor/             # Composer autoloader
└── composer.json
```

## Usage Guide

### Routing

Routes are defined in `src/routes.php`. The file returns an array where the key is the URI and the value is the controller and method to execute.

**Example:**
```php
// src/routes.php
use App\Controllers\HomeController;

return [
    // Maps the root URL ('/') to the 'index' method of HomeController
    '' => [HomeController::class, 'index'],

    // Maps '/home/about' to the 'about' method
    'home/about' => [HomeController::class, 'about'],
];
```

### Controllers

Controllers handle the logic for your application's pages. They should be placed in `src/Controllers` and extend the base `App\Core\Controller`.

**Example:**
```php
// src/Controllers/PageController.php
namespace App\Controllers;

use App\Core\Controller;

class PageController extends Controller
{
    public function show(): void
    {
        $data = [
            'title' => 'My Page',
            'content' => 'Welcome to my awesome page!'
        ];

        $this->render('pages/show', $data);
    }
}
```

### Views & Layouts

Views are the presentation layer of your application and are located in `src/Views`. They are rendered within a layout file (by default, `src/Views/layouts/main.php`).

You can pass data from your controller to the view using the `$data` array in the `render()` method. The keys of the array are extracted into variables within the view.

**Example View:**
```php
// src/Views/pages/show.php

<h2><?= $title ?></h2>
<p><?= $content ?></p>
```

The `$content` from the view is injected into the layout file where `<?= $content ?>` is placed.

### Models

Models are responsible for database interactions. They should be placed in `src/Models`. You can use the `App\Core\Database` class to get a PDO instance.

**Example:**
```php
// src/Models/User.php
namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $config = require BASE_PATH . '/src/config.php';
        $this->db = Database::getInstance($config);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}
```

## License

TinyMVC is licensed under the [MIT License](LICENSE.md). Feel free to use, modify, and redistribute it as you wish.