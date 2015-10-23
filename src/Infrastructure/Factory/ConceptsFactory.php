<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Concept\Skill;
use Mikron\HubBack\Domain\Concept\SkillGroup;
use Mikron\HubBack\Domain\Value\Code;
use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

/**
 * Class ConceptsFactory
 * @package Mikron\HubBack\Infrastructure\Factory
 */
class ConceptsFactory
{
    public function createSkillFromArray($payload)
    {
        return new Skill(new Code($payload['code']), new Name($payload['name'], 'en'), new Description($payload['description'], 'en'));
    }

    public function createSkillGroupFromArray($payload)
    {
        return new SkillGroup(new Code($payload['code']), new Name($payload['name'], 'en'), new Description($payload['description'], 'en'));
    }

    public function createSkillsFromConfig($config)
    {
        $created = [];

        foreach ($config as $configItem) {
            $created[] = $this->createSkillFromArray($configItem);
        }

        return $created;
    }

    public function createSkillGroupsFromConfig($config)
    {
        $created = [];

        foreach ($config as $configItem) {
            $created[] = $this->createSkillGroupFromArray($configItem);
        }

        return $created;
    }
}
