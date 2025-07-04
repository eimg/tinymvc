<?php
declare(strict_types=1);

// Project root
define('BASE_PATH', dirname(__DIR__));

// Autoloader
require BASE_PATH . '/vendor/autoload.php';

// Load configuration
$config = require BASE_PATH . '/src/config.php';

// Instantiate and run the application
$app = new App\Core\Application($config);
$app->run();
