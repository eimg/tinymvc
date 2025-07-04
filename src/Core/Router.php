<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    protected array $routes = [];

    public function __construct()
    {
        $routes = require BASE_PATH . '/src/routes.php';
        foreach ($routes as $key => $value) {
            $this->routes[trim($key, '/')] = $value;
        }
    }

    public function dispatch(string $uri): void
    {
        $uri = trim($uri, '/');

        if ($uri === 'home') {
            $uri = '';
        }

        if (array_key_exists($uri, $this->routes)) {
            $action = $this->routes[$uri];
            if (is_callable($action)) {
                call_user_func($action);
            } elseif (is_array($action)) {
                [$class, $method] = $action;
                if (class_exists($class) && method_exists($class, $method)) {
                    $controller = new $class();
                    $controller->$method();
                }
            }
        } else {
            // Handle 404
            http_response_code(404);
            require BASE_PATH . '/public/404.html';
        }
    }
}
