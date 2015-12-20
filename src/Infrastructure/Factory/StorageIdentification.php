<?php

namespace Mikron\HubBack\Infrastructure\Factory;

final class StorageIdentification
{
    public function createFromArray($array)
    {
        return $this->createFromData($array['dbId'], $array['key']);
    }

    public function createFromData($dbId, $key)
    {
        return new \Mikron\HubBack\Domain\Value\StorageIdentification($dbId, $key);
    }
}