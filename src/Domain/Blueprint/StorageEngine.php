<?php

namespace Mikron\HubBack\Domain\Blueprint;

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
     * @param string $table
     * @param string $primaryKeyName
     * @param string $keyName
     * @param mixed $keyValues
     * @return mixed
     */
    public function selectByKey($table, $primaryKeyName, $keyName, $keyValues);

    /**
     * @param string $table
     * @param string $primaryKeyName
     * @param mixed $primaryKeyValues
     * @return mixed
     */
    public function selectByPrimaryKey($table, $primaryKeyName, $primaryKeyValues);
}
