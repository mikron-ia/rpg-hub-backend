<?php

namespace Mikron\HubBack\Infrastructure\Storage;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage;

/**
 * Class MySqlStorage
 * @package Mikron\HubBack\Infrastructure\Storage
 */
final class MySqlStorageEngine implements StorageEngine
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param string $table Name of the table
     * @param string $primaryKeyName Name of the primary key
     * @param string $keyName Name of the key in condition
     * @param string|int $keyValues Values to search by
     * @param string $orderName Key to order by
     * @param boolean $orderDesc Descend order if true
     * @return array
     * @throws ExceptionWithSafeMessage
     */
    public function selectByKey($table, $primaryKeyName, $keyName, $keyValues, $orderName, $orderDesc)
    {
        $basicSql = "SELECT * FROM `$table`";

        if (!empty($orderName)) {
            $orderSql = " ORDER BY `$orderName` " . ($orderDesc ? "DESC" : "ASC");
        } else {
            $orderSql = "";
        }

        try {
            if (!empty($keyValues)) {
                $where = " WHERE `$keyName` IN (?)";
                $statement = $this->connection->executeQuery(
                    $basicSql . $where . $orderSql,
                    [$keyValues],
                    [Connection::PARAM_STR_ARRAY]
                );
            } else {
                $statement = $this->connection->executeQuery($basicSql . $orderSql);
            }
        } catch (\Exception $e) {
            throw new ExceptionWithSafeMessage(
                'Database connection error',
                'Database connection error: ' . $e->getMessage()
            );
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string[] $dbConfig
     * @throws ExceptionWithSafeMessage
     */
    public function __construct($dbConfig)
    {
        try {
            $config = new Configuration();
            $this->connection = DriverManager::getConnection($dbConfig, $config);
            $this->connection->executeQuery('SELECT 0');
        } catch (\Exception $e) {
            throw new ExceptionWithSafeMessage(
                'Database connection test failed',
                'Database connection test failed: ' . $e->getMessage()
            );
        }
    }

    public function selectAll($table, $primaryKeyName)
    {
        return $this->selectByKey($table, $primaryKeyName, null, [], null, null);
    }

    public function selectByPrimaryKey($table, $primaryKeyName, $primaryKeyValues)
    {
        return $this->selectByKey($table, $primaryKeyName, $primaryKeyName, $primaryKeyValues, null, null);
    }

    private function selectNewestWithConditions($table, $primaryKeyName, $keyName, $keyValues, $orderName)
    {
        return $this->selectByKey($table, $primaryKeyName, $keyName, $keyValues, $orderName, true);
    }

    public function selectNewest($table, $primaryKeyName, $orderName)
    {
        return $this->selectNewestWithConditions($table, $primaryKeyName, '', [], $orderName);
    }
}
