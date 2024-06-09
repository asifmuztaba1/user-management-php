<?php

namespace Asifmuztaba\UserManagement\Migrations;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;

return new class {
    public static function up()
    {
        $db = new DatabaseManager();
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        $db->getConnection()->exec($sql);
        $db->getConnection()->exec("ALTER TABLE users ADD UNIQUE (email)");
        echo "Migration executed successfully: Created users table\n";
    }

    public static function down()
    {
        $db = new DatabaseManager();
        $sql = "DROP TABLE IF EXISTS users";
        $db->getConnection()->exec($sql);
        echo "Rollback executed successfully: Dropped users table\n";
    }
};