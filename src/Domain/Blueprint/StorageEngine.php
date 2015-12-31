<?php

namespace Mikron\HubBack\Domain\Blueprint;

use Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage;

/**
 * Interface Storage - responsible for blueprinting storage implementations
 * @package Mikron\ReputationList\Domain\Blueprint
 */
interface StorageEngine
{
    /**
     * @param string $table
     * @param string $primaryKeyName
     * @return mixed
     */
    public function selectAll($table, $primaryKeyName);

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
    public function selectByKey($table, $primaryKeyName, $keyName, $keyValues, $orderName, $orderDesc);

    /**
     * @param string $table
     * @param string $primaryKeyName
     * @param string|int $primaryKeyValues
     * @return mixed
     */
    public function selectByPrimaryKey($table, $primaryKeyName, $primaryKeyValues);

    /**
     * @param string $table
     * @param string $primaryKeyName
     * @param string $keyName
     * @param string|int $keyValues
     * @param string $orderName
     * @return mixed
     */
    public function selectNewestWithConditions($table, $primaryKeyName, $keyName, $keyValues, $orderName);

    /**
     * @param string $table
     * @param string $primaryKeyName
     * @param string $orderName
     * @return mixed
     */
    public function selectNewest($table, $primaryKeyName, $orderName);
}
