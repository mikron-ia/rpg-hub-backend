<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class ComplexDataObject is intended for objects that have their content proper (like description) stored in the
 * backend, like Character or Person. It is intended to work with descriptions and similar elements.
 *
 * @package Mikron\HubBack\Domain\Entity
 */
class ComplexDataObject extends BasicDataObject
{
    private $descriptions;

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param array $descriptions
     */
    public function __construct($identification, $name, $data, array $help, array $descriptions)
    {
        parent::__construct($identification, $name, $data, $help);
        $this->descriptions = $descriptions;
    }

    /**
     * @return array
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }
}
