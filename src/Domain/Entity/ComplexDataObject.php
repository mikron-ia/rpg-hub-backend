<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\DescriptionPack;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Domain\Value\Tag;

/**
 * Class ComplexDataObject is intended for objects that have their content proper (like description) stored in the
 * backend, like Character or Person. It is intended to work with descriptions, tags and similar generic components.
 *
 * @package Mikron\HubBack\Domain\Entity
 */
class ComplexDataObject extends BasicDataObject
{
    /**
     * @var DescriptionPack
     */
    private $descriptionPack;

    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @var string
     */
    private $tagLine;

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param DescriptionPack $descriptionPack
     * @param Tag[] $tags
     * @param string $tagLine
     */
    public function __construct($identification, $name, $data, array $help, $descriptionPack, array $tags, $tagLine)
    {
        parent::__construct($identification, $name, $data, $help);
        $this->descriptionPack = $descriptionPack;
        $this->tags = $tags;
        $this->tagLine = $tagLine;
    }

    /**
     * @return DescriptionPack
     */
    public function getDescriptionPack()
    {
        return $this->descriptionPack;
    }

    /**
     * @return Description[]
     */
    public function getDescriptionsAsText()
    {
        if (empty($this->descriptionPack)) {
            return [];
        } else {
            return $this->descriptionPack->getDescriptionsAsText();
        }
    }

    /**
     * @return string[]
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
     * @return string
     */
    public function getTagLine()
    {
        return $this->tagLine;
    }

    /**
     * @inheritDoc
     */
    public function getSimpleData()
    {
        $simpleData = parent::getSimpleData();

        $complexData = [
            'tags' => $this->getTagsAsText(),
            'tagline' => $this->getTagLine(),
        ];

        return array_merge($simpleData, $complexData);
    }

    public function getCompleteData()
    {
        $simpleData = parent::getCompleteData();

        $complexData = [
            'descriptions' => $this->getDescriptionsAsText(),
            'tags' => $this->getTagsAsText(),
            'tagline' => $this->getTagLine(),
        ];

        return array_merge($simpleData, $complexData);
    }
}
