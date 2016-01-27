<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Domain\Value\Tag;

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
     * @var Tag[]
     */
    private $tags;

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param Description[] $descriptions
     * @param Tag[] $tags
     */
    public function __construct($identification, $name, $data, array $help, array $descriptions, array $tags)
    {
        parent::__construct($identification, $name, $data, $help);
        $this->descriptions = $descriptions;
        $this->tags = $tags;
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

    /**
     * @return array
     */
    public function getTagsAsText()
    {
        $array = [];

        foreach ($this->tags as $tag) {
            $array[] = $tag->getCompleteData();
        }

        return $array;
    }

    /**
     * @inheritDoc
     */
    public function getSimpleData()
    {
        $simpleData = parent::getSimpleData();

        $complexData = [
            'tags' => $this->getTagsAsText(),
        ];

        return array_merge_recursive($simpleData, $complexData);
    }

    public function getCompleteData()
    {
        $simpleData = parent::getCompleteData();

        $complexData = [
            'descriptions' => $this->getDescriptionsAsText(),
            'tags' => $this->getTagsAsText(),
        ];

        return array_merge_recursive($simpleData, $complexData);
    }
}
