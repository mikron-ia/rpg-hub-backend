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
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param array $data
     */
    public function __construct($identification, $name, array $data)
    {
        $this->name = $name;
        $this->identification = $identification;
        $this->data = $data;
    }

    /**
     * @return StorageIdentification
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return DataContainer
     */
    public function getData()
    {
        return $this->data;
    }
}
