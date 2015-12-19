<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\StorageIdentification;

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
     * @var Person Person data
     */
    private $person;

    /**
     * @var DataContainer Unstructured data
     */
    private $data;

    /**
     * @var StorageIdentification
     */
    private $storageData;

    /**
     * Character constructor.
     * @param string $name
     * @param StorageIdentification|null $storageData
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
