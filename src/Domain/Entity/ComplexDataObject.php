<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class ComplexDataObject is intended for objects that have their content proper (like description) stored in the
 * backend, like Character or Person. It is intended to work with descriptions and similar elements.
 *
 * @package Mikron\HubBack\Domain\Entity
 */
class ComplexDataObject extends BasicDataObject
{
    /**
     * @var Description[]
     */
    private $descriptions;

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param Description[] $descriptions
     */
    public function __construct($identification, $name, $data, array $help, array $descriptions)
    {
        parent::__construct($identification, $name, $data, $help);
        $this->descriptions = $descriptions;
    }

    /**
     * @return Description[]
     */
    public function getDescriptions()
    {
        $descriptions = [];

        foreach ($this->descriptions as $description) {
            $descriptions[$description->getTitle()] = $description;
        }

        return $descriptions;
    }

    public function getDescriptionsAsText()
    {
        $texts = [];

        foreach ($this->descriptions as $description) {
            $texts[$description->getTitle()] = $description->getPublicText();
        }

        return $texts;
    }

    public function getCompleteData()
    {
        $simpleData = parent::getCompleteData();

        $complexData = [
            'descriptions' => $this->getDescriptionsAsText()
        ];

        return array_merge_recursive($simpleData, $complexData);
    }
}
