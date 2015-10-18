<?php

namespace Mikron\HubBack\Domain\Blueprint;

/**
 * Interface Storage - responsible for blueprinting storage implementations
 * @package Mikron\ReputationList\Domain\Blueprint
 */
interface StorageEngine
{
    public function selectAll($table, $primaryKeyName);

    public function selectByKey($table, $primaryKeyName, $keyName, $keyValues);

    public function selectByPrimaryKey($table, $primaryKeyName, $primaryKeyValues);
}
