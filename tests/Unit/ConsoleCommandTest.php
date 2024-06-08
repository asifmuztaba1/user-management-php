<?php

namespace Unit;

use PHPUnit\Framework\TestCase;

/**
 *
 */
class ConsoleCommandTest extends TestCase
{
    /**
     * @var string
     */
    private string $migrationsDirectory = __DIR__ . '/../../src/Migrations';
    /**
     * @var array
     */
    private array $createdFiles = [];

    /**
     * @return void
     */
    public function testMakeMigration()
    {
        $command = 'php ' . __DIR__ . '/../../src/Console/make.php makemigration name:testMigration';
        exec($command, $output, $returnVar);

        $this->assertEquals(0, $returnVar);
        $this->assertStringContainsString('Created migration:', implode("\n", $output));

        // Add created migration file to the cleanup list
        $migrationFile = $this->getFirstMigrationFile();
        if ($migrationFile) {
            $this->createdFiles[] = $migrationFile;
        }
    }

    /**
     * @return string|null
     */
    private function getFirstMigrationFile(): ?string
    {
        $files = glob($this->migrationsDirectory . '/*.php');
        return $files[0] ?? null;
    }

    /**
     * @return void
     */
    public function testMigrate()
    {
        $migrationFile = $this->getFirstMigrationFile();
        if (!$migrationFile) {
            $migrationFile = $this->createMockMigrationFile();
        }

        $command = 'php ' . __DIR__ . '/../../src/Console/make.php migrate name:' . basename($migrationFile);
        exec($command, $output, $returnVar);
        $this->assertEquals(0, $returnVar);
        $this->assertStringContainsString('Ran migration:', implode("\n", $output));
    }

    /**
     * @return string
     */
    private function createMockMigrationFile(): string
    {
        $migrationFile = $this->migrationsDirectory . '/MockMigration.php';
        file_put_contents(
            $migrationFile,
            <<<'PHP'
        <?php
        return new class 
        {
            public static function up()
            {
                // Migration logic for up
            }

            public static function down()
            {
                // Migration logic for down
            }
        };
        PHP
        );
        $this->createdFiles[] = $migrationFile; // Add created migration file to the cleanup list
        return $migrationFile;
    }

    /**
     * @return void
     */
    public function testMigrateAll()
    {
        // Ensure the migration file exists before running the migrateall command
        $this->createMockMigrationFile();

        $command = 'php ' . __DIR__ . '/../../src/Console/make.php migrateall';
        exec($command, $output, $returnVar);

        $this->assertEquals(0, $returnVar);
        $this->assertStringContainsString('All migrations ran successfully.', implode("\n", $output));
    }

    /**
     * @return void
     */
    public function testRollBack()
    {
        // Ensure the migration file exists before running the rollback command
        $this->createMockMigrationFile();

        $command = 'php ' . __DIR__ . '/../../src/Console/make.php rollback';
        exec($command, $output, $returnVar);

        $this->assertEquals(0, $returnVar);
        $this->assertStringContainsString('Migration Rollback successfully.', implode("\n", $output));
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        // Create migrations directory if it doesn't exist
        if (!is_dir($this->migrationsDirectory)) {
            mkdir($this->migrationsDirectory, 0777, true);
        }
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        foreach ($this->createdFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
