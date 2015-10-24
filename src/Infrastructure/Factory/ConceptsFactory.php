<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\Collectible;
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
     * @param SkillGroupCollection $completeSkillGroupCollection
     * @return Skill
     * @throws IncorrectConfigurationComponentException
     */
    public function createSkillFromArray($payload, $completeSkillGroupCollection)
    {
        $skillGroupListForSkill = [];

        foreach ($payload['groups'] as $skillGroupName) {
            $skillGroup = $completeSkillGroupCollection->findByIndex($skillGroupName);
            if ($skillGroup === null) {
                throw new IncorrectConfigurationComponentException("Non-existing skill group name '$skillGroupName' in configuration of " . $payload['code'] . " skill");
            }

            $skillGroupListForSkill[] = $skillGroup;
        }

        $skillSkillGroupCollection = $this->createSkillGroupCollectionFromList($skillGroupListForSkill);

        return new Skill(new Code($payload['code']), new Name($payload['name'], 'en'), new Description($payload['description'], 'en'), $skillSkillGroupCollection);
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

    /**
     * @param array $array
     * @return SkillGroupCollection
     */
    public function createSkillGroupCollectionFromList(array $array)
    {
        $created = [];

        foreach ($array as $arrayItem) {
            if ($arrayItem instanceof SkillGroup) {
                $created[] = $arrayItem;
            } else {
                $created[] = $this->createSkillGroupFromArray($arrayItem);
            }
        }

        $collection = new SkillGroupCollection($created);

        return $collection;
    }
}
