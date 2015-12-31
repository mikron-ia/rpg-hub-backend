<?php

namespace Mikron\HubBack\Infrastructure\Storage;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Storage\StorageForObject;

final class StorageForRecap implements StorageForObject
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
        $result = $this->storage->selectByPrimaryKey('recap', 'recap_id', [$dbId]);

        return $result;
    }

    public function retrieveByKey($key)
    {
        $result = $this->storage->selectByKey('recap', 'recap_id', 'key', [$key], null, false);

        return $result;
    }

    public function retrieveAll()
    {
        $result = $this->storage->selectAll('recap', 'recap_id');

        return $result;
    }

    public function retrieveNewest()
    {
        $result = $this->storage->selectNewest('recap', 'recap_id', 'time');

        return $result;
    }
}
