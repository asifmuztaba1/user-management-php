<?php

namespace Asifmuztaba\UserManagement\Managers;


/**
 *
 */
class MigrationCoreManager
{
    /**
     * @var array|false
     */
    private array|false $migrationFiles;
    /**
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    /**
     * @param $migrationsDirectory
     * @param DatabaseManager|null $databaseManager
     */
    public function __construct($migrationsDirectory, DatabaseManager $databaseManager = null)
    {
        $this->migrationFiles = glob($migrationsDirectory . '/*.php');
        $this->ensureMigrationsTableExists();
        $this->databaseManager = $databaseManager ?? new DatabaseManager();
    }

    /**
     * @return void
     */
    private function ensureMigrationsTableExists(): void
    {
        $databaseManager = new DatabaseManager();

        $databaseManager->createTable('migrations', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'migration' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
    }

    /**
     * Run a single migration file.
     *
     * @param string $migrationFile The filename of the migration to run.
     */
    public function runMigration(string $migrationFile): void
    {
        require_once __DIR__ . '/../Migrations/' . $migrationFile;

        // Extract class name from filename
        $className = pathinfo($migrationFile, PATHINFO_FILENAME);

        if (class_exists($className)) {
            // Call the up method of the migration class
            $className::up();
        } else {
            echo "Class $className not found in $migrationFile\n";
        }
    }

    /**
     * @return void
     */
    public function runAllMigrations(): void
    {
        foreach ($this->migrationFiles as $file) {
            $migration = include $file;
            if (method_exists($migration, 'up') && method_exists($migration, 'down')) {
                $className = pathinfo($file, PATHINFO_FILENAME);
                echo "Running migration: $className\n";

                // Check if migration has already been run
                if (!$this->migrationHasRun($className)) {
                    $migration::up();
                    $this->markMigrationAsRun($className);
                }
            } else {
                echo "Skipping invalid migration file: $file\n";
            }
        }
    }

    /**
     * Check if a migration has already been run.
     *
     * @param string $className The migration class name.
     * @return bool Whether the migration has been run.
     */
    private function migrationHasRun(string $className): bool
    {
        $db = $this->databaseManager->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
        $stmt->execute([$className]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Mark a migration as having been run.
     *
     * @param string $className The migration class name.
     */
    private function markMigrationAsRun(string $className): void
    {
        $db = $this->databaseManager->getConnection();
        $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$className]);
    }

    /**
     * @return void
     */
    public function rollBack(): void
    {
        foreach ($this->migrationFiles as $file) {
            $migration = include $file;
            if (method_exists($migration, 'up') && method_exists($migration, 'down')) {
                $className = pathinfo($file, PATHINFO_FILENAME);
                echo "Rollback migration: $className\n";

                if ($this->migrationHasRun($className)) {
                    $migration::down();
                    $this->unmarkMigrationAsRun($className);
                }
            } else {
                echo "Skipping invalid migration file: $file\n";
            }
        }
    }

    /**
     * Unmark a migration as having been run.
     *
     * @param string $className The migration class name.
     */
    private function unmarkMigrationAsRun(string $className): void
    {
        $db = $this->databaseManager->getConnection();
        $stmt = $db->prepare("DELETE FROM migrations WHERE migration = ?");
        $stmt->execute([$className]);
    }
}
