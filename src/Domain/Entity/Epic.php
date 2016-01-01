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
     * @var Story[] Story data
     */
    private $stories;

    /**
     * @var Recap Recent events
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

    public function getCompleteData()
    {
        $stories = $this->getStories();
        $ownData = [
            'stories' => [],
            'current' => $this->recap->getCompleteData()
        ];

        foreach($stories as $story) {
            $ownData['stories'][] = $story->getSimpleData();
        }

        $ownData['stories'] = array_reverse($ownData['stories']);

        return array_merge_recursive(parent::getCompleteData(), $ownData);
    }
}
