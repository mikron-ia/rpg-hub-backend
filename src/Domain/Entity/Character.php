<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class Character - abstract concepts that aggregates everything that makes a character
 * @package Mikron\HubBack\Domain\Entity
 */
final class Character extends BasicDataObject
{
    /**
     * @var Person Person data
     */
    private $person;

    /**
     * Character constructor.
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Person|null $person
     * @param DataContainer $data
     */
    public function __construct($identification, $name, $person, $data)
    {
        parent::__construct($identification, $name, $data);
        $this->person = $person;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}
