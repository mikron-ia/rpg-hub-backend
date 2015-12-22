<?php

namespace Mikron\HubBack\Infrastructure\Storage;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Storage\StorageForObject;

final class StorageForPerson implements StorageForObject
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
        $result = $this->storage->selectByPrimaryKey('person', 'person_id', [$dbId]);

        return $result;
    }

    public function retrieveByKey($key)
    {
        $result = $this->storage->selectByKey('person', 'person_id', 'key', [$key]);

        return $result;
    }

    public function retrieveAll()
    {
        $result = $this->storage->selectAll('person', 'person_id');

        return $result;
    }
}
