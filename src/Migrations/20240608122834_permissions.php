<?php

namespace Asifmuztaba\UserManagement\Migrations;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;

return new class {
    public static function up()
    {
        $db = new DatabaseManager();

        // Create permissions table
        $sql = "
            CREATE TABLE IF NOT EXISTS permissions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                description VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        $db->getConnection()->exec($sql);

        echo "Migration executed successfully: Created permissions table\n";
    }

    public static function down()
    {
        $db = new DatabaseManager();

        // Drop permissions table
        $sql = "DROP TABLE IF EXISTS permissions";
        $db->getConnection()->exec($sql);

        echo "Rollback executed successfully: Dropped permissions table\n";
    }
};
