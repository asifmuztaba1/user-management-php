<?php

namespace Asifmuztaba\UserManagement\Models;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;

class Role
{
    public static function findByName($name)
    {
        $db = new DatabaseManager();
        $stmt = $db->getConnection()->prepare("SELECT * FROM roles WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public static function findById($id)
    {
        $db = new DatabaseManager();
        $stmt = $db->getConnection()->prepare("SELECT * FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
