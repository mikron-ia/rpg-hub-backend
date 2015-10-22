<?php

namespace Mikron\HubBack\Domain\Concept;

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

/**
 * Class Skill - numeric representation of an ability
 * @package Mikron\HubBack\Domain\Concept
 */
class Skill implements Displayable
{
	/**
	 * @var Name
	 */
	private $name;

	/**
	 * @var Description
	 */
	private $description;

	/**
	 * Skill constructor.
	 * @param Name $name
	 * @param Description $description
	 */
	public function __construct(Name $name, Description $description)
	{
		$this->name = $name;
		$this->description = $description;
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
}
