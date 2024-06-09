<?php

namespace Asifmuztaba\UserManagement\Migrations;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;

return new class {
    public static function up()
    {
        $db = new DatabaseManager();

        // Create role_permissions pivot table
        $sql = "
            CREATE TABLE IF NOT EXISTS role_permissions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                role_id INT NOT NULL,
                permission_id INT NOT NULL,
                FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
                FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        $db->getConnection()->exec($sql);

        echo "Migration executed successfully: Created role_permissions pivot table\n";
    }

    public static function down()
    {
        $db = new DatabaseManager();

        // Drop permission_role pivot table
        $sql = "DROP TABLE IF EXISTS permission_role";
        $db->getConnection()->exec($sql);

        echo "Rollback executed successfully: Dropped permission_role pivot table\n";
    }
};
