<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Concept\Skill;
use Mikron\HubBack\Domain\Concept\SkillGroup;
use Mikron\HubBack\Domain\Concept\SkillGroupCollection;
use Mikron\HubBack\Domain\Exception\IncorrectConfigurationComponentException;
use Mikron\HubBack\Domain\Value\Code;
use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

/**
 * Class ConceptsFactory
 * @package Mikron\HubBack\Infrastructure\Factory
 */
class ConceptsFactory
{
    /**
     * @param array $payload
     * @param SkillGroupCollection $skillGroupCollection
     * @return Skill
     * @throws IncorrectConfigurationComponentException
     */
    public function createSkillFromArray($payload, $skillGroupCollection)
    {
        $skillGroups = [];

        foreach ($payload['groups'] as $skillGroupName) {
            $skillGroup = $skillGroupCollection->findByIndex($skillGroupName);
            if ($skillGroup === null) {
                throw new IncorrectConfigurationComponentException("Non-existing skill group name '$skillGroupName' in configuration of " . $payload['code'] . " skill");
            }
        }

        return new Skill(new Code($payload['code']), new Name($payload['name'], 'en'), new Description($payload['description'], 'en'), []);
    }

    public function createSkillGroupFromArray($payload)
    {
        return new SkillGroup(new Code($payload['code']), new Name($payload['name'], 'en'), new Description($payload['description'], 'en'));
    }

    /**
     * @param $config
     * @param SkillGroup[] $skillGroups
     * @return array
     */
    public function createSkillsFromConfig($config, $skillGroups)
    {
        $created = [];

        foreach ($config as $configItem) {
            $created[] = $this->createSkillFromArray($configItem, $skillGroups);
        }

        return $created;
    }

    public function createSkillGroupCollectionFromList($config)
    {
        $created = [];

        foreach ($config as $configItem) {
            $created[] = $this->createSkillGroupFromArray($configItem);
        }

        $collection = new SkillGroupCollection($created);

        return $collection;
    }
}
