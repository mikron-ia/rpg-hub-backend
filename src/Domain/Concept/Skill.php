<?php

namespace Mikron\HubBack\Domain\Concept;

use Mikron\HubBack\Domain\Blueprint\Collectible;
use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Value\Code;
use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

/**
 * Class Skill - numeric representation of an ability
 * @package Mikron\HubBack\Domain\Concept
 */
class Skill implements Collectible, Displayable
{
    /**
     * @var Code
     */
    private $code;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var Description
     */
    private $description;

    /**
     * @var SkillGroupCollection
     */
    private $skillGroups;

    /**
     * Skill constructor.
     * @param Code $code
     * @param Name $name
     * @param Description $description
     * @param SkillGroupCollection $skillGroupCollection Skill groups the skill belongs to; this may be empty
     */
    public function __construct(Code $code, Name $name, Description $description, SkillGroupCollection $skillGroupCollection)
    {
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->skillGroups = $skillGroupCollection;
    }

    /**
     * @return Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array Simple representation of the object content, fit for basic display
     */
    public function getSimpleData()
    {
        return [
            "name" => $this->getName()
        ];
    }

    /**
     * @return array Complete representation of public parts of object content, fit for full card display
     */
    public function getCompleteData()
    {
        return [
            "name" => $this->getName(),
            "description" => $this->getDescription()
        ];
    }

    public function getKey()
    {
        return $this->code->getCode();
    }
}
