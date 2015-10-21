<?php

namespace Mikron\HubBack\Infrastructure\Storage;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class MySqlStorage
 * @package Mikron\HubBack\Infrastructure\Storage
 */
final class MySqlStorageEngine implements StorageEngine
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * @param $table
     * @param $primaryKeyName
     * @param $keyName
     * @param $keyValues
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function selectByKey($table, $primaryKeyName, $keyName, $keyValues)
    {
        $basicSql = "SELECT * FROM `$table`";

        if (!empty($keyValues)) {
            $where = " WHERE $keyName IN (?)";
            $statement = $this->connection->executeQuery($basicSql . $where,
                [$keyValues],
                [\Doctrine\DBAL\Connection::PARAM_INT_ARRAY]
            );
        } else {
            $statement = $this->connection->executeQuery($basicSql);
        }

        return $statement->fetchAll((\PDO::FETCH_ASSOC));
    }

    /**
     * @param $dbConfig
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct($dbConfig)
    {
        try {
            $config = new Configuration();
            $this->connection = DriverManager::getConnection($dbConfig, $config);
        } catch (\PDOException $e) {
            throw new Exception('Could not connect to MySQL database: ' . $e->getMessage());
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
