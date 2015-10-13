<?php

namespace Mikron\HubBack\Domain\Entity;

/**
 * Class Ego - aggregator for personality, skills, and many other things residing in mind
 * @package Mikron\HubBack\Domain\Entity
 */
class Ego
{
	/**
	 * @var Skill[]
	 */
	private $skills;

	/**
	 * @var SkillGroup[]
	 */
	private $skillGroups;
}
