<?php

namespace Mikron\HubBack\Domain\Value;

/**
 * Class DescriptionPack
 * @package Mikron\HubBack\Domain\Value
 */
class DescriptionPack
{
    /**
     * @var Description[]
     */
    private $descriptions;

    /**
     * DescriptionPack constructor.
     * @param Description[] $descriptions
     */
    public function __construct(array $descriptions)
    {
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
}
