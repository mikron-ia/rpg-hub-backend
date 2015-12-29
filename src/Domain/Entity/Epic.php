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
     * @var Story Story data
     */
    private $stories;

    /**
     * Character constructor.
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param Story[] $stories
     */
    public function __construct($identification, $name, $data, $help, $stories)
    {
        parent::__construct($identification, $name, $data, $help);
        $this->stories = $stories;
    }

    /**
     * @return Story|null
     */
    public function getStory()
    {
        return $this->stories;
    }

    public function getCompleteData()
    {
        $stories = $this->getStory();
        $ownData = [
            'stories' => [],
        ];

        foreach($stories as $story) {
            $ownData['stories'][] = $story->getSimpleData();
        }

        $ownData['stories'] = array_reverse($ownData['stories']);

        return array_merge_recursive(parent::getCompleteData(), $ownData);
    }
}
