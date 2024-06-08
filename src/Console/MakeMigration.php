<?php

namespace Asifmuztaba\UserManagement\Console;

class MakeMigration
{
    /**
     * Generate a new migration file with a timestamped filename.
     *
     * @param string $name The name of the migration class.
     * @return string The filename of the created migration.
     */
    public static function generate(string $name): string
    {
        $timestamp = date('YmdHis');
        $filename = "{$timestamp}_{$name}.php";
        $filepath = __DIR__ . '/../../' . "src/Migrations/{$filename}";

        // Create the migration file template
        $template = <<<PHP
        <?php

        namespace Asifmuztaba\UserManagement\Migrations;

        use Asifmuztaba\UserManagement\Database\Database;

        return new class
        {
            public static function up()
            {
                // Write your migration code to create tables, alter tables, etc.
            }

            public static function down()
            {
                // Write your rollback code if needed
            }
        };
        PHP;

        // Write the template to the migration file
        file_put_contents($filepath, $template);

        return $filename;
    }
}
