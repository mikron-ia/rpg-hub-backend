<?php

namespace Mikron\HubBack\Infrastructure\Storage;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Storage\StorageForObject;

final class StorageForCharacter implements StorageForObject
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
        $result = $this->storage->selectByPrimaryKey('character', 'character_id', [$dbId]);

        return $result;
    }

    public function retrieveByKey($key)
    {
        $result = $this->storage->selectByKey('character', 'character_id', 'key', [$key], null, false);

        return $result;
    }

    public function retrieveAll()
    {
        $result = $this->storage->selectAll('character', 'character_id');

        return $result;
    }
}
