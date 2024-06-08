<?php

namespace Unit;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;
use PHPUnit\Framework\TestCase;

/**
 * This is test for database service
 */
class DatabaseManagerTest extends TestCase
{
    /**
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    /**
     * @return void
     */
    public function testCreateTable()
    {
        $this->databaseManager->createTable('test_table', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL'
        ]);

        $result = $this->databaseManager->getConnection()->query("SHOW TABLES LIKE 'test_table'")->fetch();
        $this->assertNotFalse($result);
    }

    /**
     * @return void
     */
    public function testInsertAndSelect()
    {
        $this->databaseManager->createTable('test_table', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL'
        ]);

        $this->databaseManager->insert('test_table', ['name' => 'Test Name']);
        $result = $this->databaseManager->select('test_table', ['name' => 'Test Name']);
        $this->assertCount(1, $result);
        $this->assertEquals('Test Name', $result[0]['name']);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $this->databaseManager->createTable('test_table', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL'
        ]);
        $this->databaseManager->insert('test_table', ['name' => 'Old Name']);
        $this->databaseManager->update('test_table', ['name' => 'New Name'], ['name' => 'Old Name']);
        $result = $this->databaseManager->select('test_table', ['name' => 'New Name']);
        $this->assertCount(1, $result);
        $this->assertEquals('New Name', $result[0]['name']);
    }

    /**
     * @return void
     */
    public function testDelete()
    {
        $this->databaseManager->createTable('test_table', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL'
        ]);

        $this->databaseManager->insert('test_table', ['name' => 'Test Name']);
        $this->databaseManager->delete('test_table', ['name' => 'Test Name']);
        $result = $this->databaseManager->select('test_table', ['name' => 'Test Name']);
        $this->assertCount(0, $result);
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->databaseManager = new DatabaseManager();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $this->databaseManager->dropTable('test_table');
    }
}
