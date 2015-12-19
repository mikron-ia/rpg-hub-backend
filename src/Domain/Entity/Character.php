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
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param $person
     * @param $data     *
     * @todo Validate data?
     */
    public function __construct($identification, $name, $person, $data)
    {
        $this->name = $name;
        $this->identification = $identification;
        $this->person = $person;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
