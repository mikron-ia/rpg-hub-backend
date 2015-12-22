<?php

namespace Mikron\HubBack\Infrastructure\Storage;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Mikron\HubBack\Domain\Blueprint\StorageEngine;

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
     * @param string $table
     * @param string $primaryKeyName
     * @param string $keyName
     * @param $keyValues
     * @return array
     * @throws DBALException
     */
    public function selectByKey($table, $primaryKeyName, $keyName, $keyValues)
    {
        $basicSql = "SELECT * FROM `$table`";

        if (!empty($keyValues)) {
            $where = " WHERE `$keyName` IN (?)";
            $statement = $this->connection->executeQuery($basicSql . $where,
                [$keyValues],
                [Connection::PARAM_STR_ARRAY]
            );
        } else {
            $statement = $this->connection->executeQuery($basicSql);
        }

        return $statement->fetchAll((\PDO::FETCH_ASSOC));
    }

    /**
     * @param string[] $dbConfig
     * @throws \Exception
     */
    public function __construct($dbConfig)
    {
        try {
            $config = new Configuration();
            $this->connection = DriverManager::getConnection($dbConfig, $config);
            $this->connection->executeQuery('SELECT 0');
        } catch (\Exception $e) {
            throw new \Exception('Database connection test failed: ' . $e->getMessage());
        }
    }

    /**
     * @param $table
     * @param $primaryKeyName
     * @return array
     */
    public function selectAll($table, $primaryKeyName)
    {
        return $this->selectByKey($table, $primaryKeyName, null, []);
    }

    public function selectByPrimaryKey($table, $primaryKeyName, $primaryKeyValues)
    {
        return $this->selectByKey($table, $primaryKeyName, $primaryKeyName, $primaryKeyValues);
    }
}
