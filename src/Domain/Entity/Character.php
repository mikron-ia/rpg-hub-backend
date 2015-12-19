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
    private $identification;

    /**
     * Character constructor.
     * @param string $name
     * @param StorageIdentification|null $identification
     */
    public function __construct($identification, $name)
    {
        $this->name = $name;
        $this->identification = $identification;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
