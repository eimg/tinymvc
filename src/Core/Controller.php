<?php
declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
