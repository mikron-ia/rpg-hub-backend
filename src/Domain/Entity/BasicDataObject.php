<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class BasicDataObject - trait for standard things like name or help data
 * @package Mikron\HubBack\Domain\Entity
 */
abstract class BasicDataObject
{
    /**
     * @var StorageIdentification
     */
    protected $identification;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var DataContainer Unstructured data
     */
    protected $data;

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     */
    public function __construct($identification, $name, $data)
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
