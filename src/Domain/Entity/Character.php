<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\StorageData;

/**
 * Class Character - abstract concepts that aggregates everything that makes a character
 * @package Mikron\HubBack\Domain\Entity
 */
class Character
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var StorageData
     */
    private $storageData;

    /**
     * Character constructor.
     * @param string $name
     * @param StorageData|null $storageData
     */
    public function __construct($name, $storageData)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
