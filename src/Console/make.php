<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Asifmuztaba\UserManagement\Console\MakeMigration;
use Asifmuztaba\UserManagement\Managers\MigrationCoreManager;

$migrationsDirectory = __DIR__ . '/../Migrations';
$migrationManager = new MigrationCoreManager($migrationsDirectory);

// Check if a command is provided
if ($argc < 2) {
    echo "Please provide a command.\n";
    exit(1);
}

// Parse the command and arguments
$command = $argv[1];

// Handle commands
switch ($command) {
    case 'makemigration':
        // Example: php src/Console/make.php makemigration:migrationname
        $parts = explode(':', $argv[2] ?? '');
        $migrationName = $parts[1] ?? null;

        if (!$migrationName) {
            echo "Please provide a name for the migration.\n";
            exit(1);
        }

        $filename = MakeMigration::generate($migrationName);
        echo "Created migration: {$filename}\n";
        break;

    case 'migrate':
        // Example: php src/Console/make.php migrate:migrationfile
        $parts = explode(':', $argv[2] ?? '');
        $migrationFile = $parts[1] ?? null;

        if (!$migrationFile) {
            echo "Please provide a migration file.\n";
            exit(1);
        }

        $migrationManager->runMigration($migrationFile);
        echo "Ran migration: {$migrationFile}\n";
        break;

    case 'migrateall':
        $migrationManager->runAllMigrations();
        echo "All migrations ran successfully.\n";
        break;

    case 'rollback':
        $migrationManager->rollBack();
        echo "Migration Rollback successfully.\n";
        break;

    default:
        echo "Command not recognized.\n";
        echo "Usage: php src/Console/make.php [makemigration:migrationname|migrate:migrationfile|migrateall]\n";
        exit(1);
}

