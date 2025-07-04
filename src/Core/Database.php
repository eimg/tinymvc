<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(array $config): PDO
    {
        if (self::$instance === null) {
            $dsn = "{$config['dbdriver']}:" . BASE_PATH . "/{$config['db']}";

            try {
                self::$instance = new PDO($dsn);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // In a real application, you'd want to log this error
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    private function __clone() {}
    public function __wakeup() {}
}
