<?php
declare(strict_types=1);

namespace App\Core;

class Application
{
    protected Router $router;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->router = new Router();
        Database::getInstance($config);
    }

    public function run(): void
    {
        $this->router->dispatch($_SERVER['REQUEST_URI']);
    }
}
