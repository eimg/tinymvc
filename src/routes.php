<?php

declare(strict_types=1);

use App\Controllers\HomeController;

return [
    '/' => [HomeController::class, 'index'],
    '/home/about' => [HomeController::class, 'about'],
    '/home/contact' => [HomeController::class, 'contact'],
    '/home/license' => [HomeController::class, 'license'],
    '/home/send' => [HomeController::class, 'send'],
];
