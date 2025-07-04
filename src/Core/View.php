<?php
declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data);

        $viewPath = BASE_PATH . "/src/Views/{$view}.php";

        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();

            $layoutPath = BASE_PATH . "/src/Views/layouts/{$layout}.php";
            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                echo "Layout not found: {$layout}";
            }
        } else {
            // Handle view not found
            echo "View not found: {$view}";
        }
    }
}
