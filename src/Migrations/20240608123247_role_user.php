<?php

namespace Asifmuztaba\UserManagement\Migrations;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;

return new class {
    public static function up()
    {
        $db = new DatabaseManager();

        // Create role_user pivot table
        $sql = "
            CREATE TABLE IF NOT EXISTS role_user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                role_id INT NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        $db->getConnection()->exec($sql);

        echo "Migration executed successfully: Created role_user pivot table\n";
    }

    public static function down()
    {
        $db = new DatabaseManager();

        // Drop role_user pivot table
        $sql = "DROP TABLE IF EXISTS role_user";
        $db->getConnection()->exec($sql);

        echo "Rollback executed successfully: Dropped role_user pivot table\n";
    }
};
