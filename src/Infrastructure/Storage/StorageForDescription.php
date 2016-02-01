<?php

namespace Mikron\HubBack\Infrastructure\Storage;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Exception\KeyNotSupportedException;
use Mikron\HubBack\Domain\Storage\StorageForObject;

/**
 * Class StorageForDescription
 * @package Mikron\HubBack\Infrastructure\Storage
 */
class StorageForDescription implements StorageForObject
{
    /**
     * @var StorageEngine
     */
    private $storage;

    /**
     * MySqlPerson constructor.
     * @param $storage
     */
    public function __construct($storage)
    {
        $this->storage = $storage;
    }

    public function retrieveById($dbId)
    {
        $result = $this->storage->selectByPrimaryKey('description', 'description_id', [$dbId]);
        return $result;
    }

    public function retrieveByKey($key)
    {
        throw new KeyNotSupportedException();
    }

    public function retrieveAll()
    {
        $result = $this->storage->selectAll('description', 'description_id');
        return $result;
    }

}