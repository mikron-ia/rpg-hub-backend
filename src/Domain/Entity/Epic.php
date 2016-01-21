<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class Epic
 * @package Mikron\HubBack\Domain\Entity
 */
class Epic extends BasicDataObject implements Displayable
{
    /**
     * @var Story[] Story data array
     */
    private $stories;

    /**
     * @var Recap Description of recent events
     */
    private $recap;

    /**
     * Character constructor.
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param Story[] $stories
     * @param Recap $recap
     */
    public function __construct($identification, $name, $data, $help, $stories, $recap)
    {
        parent::__construct($identification, $name, $data, $help);
        $this->stories = $stories;
        $this->recap = $recap;
    }

    /**
     * @return Story[]
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**
     * @return Recap
     */
    public function getRecap()
    {
        return $this->recap;
    }

    public function getCompleteData()
    {
        $stories = $this->getStories();
        $ownData = [
            'stories' => [],
            'current' => (isset($this->recap) ? $this->getRecap()->getCompleteData() : null)
        ];

        foreach ($stories as $story) {
            $ownData['stories'][] = $story->getSimpleData();
        }

        $ownData['stories'] = array_reverse($ownData['stories']);

        return array_merge_recursive(parent::getCompleteData(), $ownData);
    }
}
