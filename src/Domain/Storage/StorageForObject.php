<?php

namespace Mikron\HubBack\Domain\Storage;

interface StorageForObject
{
    /**
     * @param int $dbId
     * @return mixed
     */
    public function retrieveById($dbId);

    /**
     * @param string $key
     * @return mixed
     */
    public function retrieveByKey($key);

    /**
     * @return mixed
     */
    public function retrieveAll();
}
