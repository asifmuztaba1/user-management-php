<?php

namespace Asifmuztaba\UserManagement\Migrations;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;

return new class {
    public static function up()
    {
        $db = new DatabaseManager();

        // Create roles table
        $sql = "
            CREATE TABLE IF NOT EXISTS roles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                description VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        $db->getConnection()->exec($sql);

        // Insert initial roles (admin and normal user)
        $db->getConnection()->exec("INSERT INTO roles (name, description) VALUES ('admin', 'Administrator role')");
        $db->getConnection()->exec("INSERT INTO roles (name, description) VALUES ('user', 'Normal user role')");

        echo "Migration executed successfully: Created roles table\n";
    }

    public static function down()
    {
        $db = new DatabaseManager();

        // Drop roles table
        $sql = "DROP TABLE IF EXISTS roles";
        $db->getConnection()->exec($sql);

        echo "Rollback executed successfully: Dropped roles table\n";
    }
};
