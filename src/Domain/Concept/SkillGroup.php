<?php

namespace Mikron\HubBack\Domain\Concept;

use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

/**
 * Class SkillGroup - representation of a profession, skill aggregation or simple group
 * @package Mikron\HubBack\Domain\Concept
 */
class SkillGroup
{
	/**
	 * @var Name
	 */
	private $name;

	/**
	 * @var Description
	 */
	private $description;
}
