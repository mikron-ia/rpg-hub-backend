<?php

namespace Mikron\HubBack\Infrastructure\Factory;

/**
 * Factory for Entity\StorageIdentification
 * @package Mikron\HubBack\Infrastructure\Factory
 */
final class StorageIdentification
{
    /**
     * @param array $array
     * @return \Mikron\HubBack\Domain\Value\StorageIdentification
     */
    public function createFromArray($array)
    {
        return $this->createFromData($array['dbId'], $array['key']);
    }

    /**
     * @param int $dbId
     * @param string $key
     * @return \Mikron\HubBack\Domain\Value\StorageIdentification
     */
    public function createFromData($dbId, $key)
    {
        return new \Mikron\HubBack\Domain\Value\StorageIdentification($dbId, $key);
    }
}
