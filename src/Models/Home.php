<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Home
{
    private PDO $db;

    public function __construct()
    {
        $config = require BASE_PATH . '/src/config.php';
        $this->db = Database::getInstance($config);
    }

    public function record_and_send_contact(array $data): bool
    {
        if (empty($data['name']) || empty($data['email']) || empty($data['msg'])) {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO contact_records (name, email, msg) VALUES (:name, :email, :msg)");

        return $stmt->execute([
            ':name' => htmlspecialchars($data['name']),
            ':email' => $data['email'],
            ':msg' => htmlspecialchars($data['msg']),
        ]);
    }
}
