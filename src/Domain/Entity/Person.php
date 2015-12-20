<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class Person - represents the face
 * @package Mikron\HubBack\Domain\Entity
 */
final class Person extends BasicDataObject
{
    /**
     * Person constructor.
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer|null $data
     */
    public function __construct($identification, $name, $data)
    {
        parent::__construct($identification, $name, $data);
    }
}
