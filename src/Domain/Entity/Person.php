<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class Person - represents the face
 * @package Mikron\HubBack\Domain\Entity
 */
class Person
{
    /**
     * @var StorageIdentification
     */
    private $identification;

    /**
     * @var string
     */
    private $name;

    /**
     * @var DataContainer
     */
    private $data;

    /**
     * Person constructor.
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
