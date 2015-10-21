<?php

namespace Mikron\HubBack\Domain\Value;

/**
 * Class StorageData - wraps identification data for DB
 * @package Mikron\HubBack\Domain\Value
 */
class StorageData
{
    /**
     * @var int
     */
    private $dbId;

    /**
     * StorageData constructor.
     * @param int $dbId
     */
    public function __construct($dbId)
    {
        $this->dbId = $dbId;
    }

    /**
     * @return int
     */
    public function getDbId()
    {
        return $this->dbId;
    }
}