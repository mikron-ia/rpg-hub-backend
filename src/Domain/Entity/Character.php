<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Value\DescriptionPack;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Domain\Value\Tag;

/**
 * Class Character - abstract concepts that aggregates everything that makes a character
 * @package Mikron\HubBack\Domain\Entity
 */
final class Character extends ComplexDataObject implements Displayable
{
    /**
     * @var Person Person data
     */
    private $person;

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param DescriptionPack $descriptionPack
     * @param Tag[] $tags
     * @param string $tagLine
     * @param Person|null $person
     */
    public function __construct($identification, $name, $data, $help, $descriptionPack, $tags, $tagLine, $person)
    {
        parent::__construct($identification, $name, $data, $help, $descriptionPack, $tags, $tagLine);
        $this->person = $person;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    public function getCompleteData()
    {
        $person = $this->getPerson();
        $ownData = [
            'person' => !empty($person)?$person->getCompleteData():null,
        ];
        return parent::getCompleteData() + $ownData;
    }
}
