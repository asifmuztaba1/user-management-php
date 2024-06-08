<?php

namespace Asifmuztaba\UserManagement\Managers;

use PDO;
use PDOException;
use Symfony\Component\Dotenv\Dotenv;

/**
 *
 */
class DatabaseManager
{
    /**
     * @var PDO
     */
    private PDO $connection;
    /**
     * @var string
     */
    private string $andOperator = ' AND ';

    /**
     *
     */
    public function __construct()
    {
        if (!isset($_ENV['DB_HOST']) || $_ENV['MYSQL_DATABASE']) {
            $dotenv = new Dotenv();
            $dotenv->load(__DIR__ . '/../../.env');
        }
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'];
        $username = $_ENV['MYSQL_USER'];
        $password = $_ENV['MYSQL_PASSWORD'];

        try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @return int|false
     */
    public function createTable(string $tableName, array $columns): int|false
    {
        $columnsSql = [];
        foreach ($columns as $name => $type) {
            $columnsSql[] = "$name $type";
        }
        $columnsSql = implode(', ', $columnsSql);
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsSql)";

        return $this->connection->exec($sql);
    }

    /**
     * @param string $tableName
     * @return int|false
     */
    public function dropTable(string $tableName): int|false
    {
        $sql = "DROP TABLE IF EXISTS $tableName";
        return $this->connection->exec($sql);
    }

    /**
     * @param string $tableName
     * @param array $data
     * @return bool
     */
    public function insert(string $tableName, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

        $stmt = $this->connection->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    /**
     * @param string $tableName
     * @param array $conditions
     * @param $columns
     * @return false|array
     */
    public function select(string $tableName, array $conditions = [], $columns = '*'): false|array
    {
        $sql = "SELECT $columns FROM $tableName";
        if (!empty($conditions)) {
            $conditionsSql = [];
            foreach ($conditions as $key => $value) {
                $conditionsSql[] = "$key = :$key";
            }
            $conditionsSql = implode($this->andOperator, $conditionsSql);
            $sql .= " WHERE $conditionsSql";
        }

        $stmt = $this->connection->prepare($sql);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $tableName
     * @param array $data
     * @param array $conditions
     * @return bool
     */
    public function update(string $tableName, array $data, array $conditions): bool
    {
        // Prepare the update part of the SQL
        $updateSql = [];
        foreach ($data as $key => $value) {
            $updateSql[] = "$key = :data_$key";
        }
        $updateSql = implode(', ', $updateSql);

        // Prepare the conditions part of the SQL
        $conditionsSql = [];
        foreach ($conditions as $key => $value) {
            $conditionsSql[] = "$key = :condition_$key";
        }
        $conditionsSql = implode($this->andOperator, $conditionsSql);

        // Construct the final SQL statement
        $sql = "UPDATE $tableName SET $updateSql WHERE $conditionsSql";
        $stmt = $this->connection->prepare($sql);

        // Bind the data values
        foreach ($data as $key => $value) {
            $stmt->bindValue(":data_$key", $value);
        }

        // Bind the condition values
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":condition_$key", $value);
        }

        // Execute the statement and return the result
        return $stmt->execute();
    }

    /**
     * @param string $tableName
     * @param array $conditions
     * @return bool
     */
    public function delete(string $tableName, array $conditions): bool
    {
        $conditionsSql = [];
        foreach ($conditions as $key => $value) {
            $conditionsSql[] = "$key = :$key";
        }
        $conditionsSql = implode($this->andOperator, $conditionsSql);

        $sql = "DELETE FROM $tableName WHERE $conditionsSql";

        $stmt = $this->connection->prepare($sql);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }
}
