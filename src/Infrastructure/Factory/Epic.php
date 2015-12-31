<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Factory for Epic objects
 * This factory is atypical due to the fact that - at the moment - there is only one epic allowed per deployment
 * @package Mikron\HubBack\Infrastructure\Factory
 */
class Epic
{
    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Entity\DataContainer|null $data
     * @param string[] $help
     * @param Entity\Story[] $stories
     * @param Entity\Recap|null $recap
     * @return Entity\Epic
     */
    public function createFromSingleArray($identification, $name, $data, $help, $stories, $recap)
    {
        return new Entity\Epic($identification, $name, $data, $help, $stories, $recap);
    }

    public function retrieveEpic($connection, $dataPatterns, $configHelp, $configEpicData)
    {
        $dataContainerFactory = new DataContainer();
        $dataContainer = $dataContainerFactory->createWithPattern($configEpicData['data'], $dataPatterns['epic']);

        $storyFactory = new Story();
        $stories = $storyFactory->retrieveAllFromDb($connection, $dataPatterns, $configHelp);

        $recapFactory = new Recap();
        $recap = $recapFactory->retrieveMostRecent($connection, $dataPatterns, $configHelp);

        return $this->createFromSingleArray(
            null,
            $configEpicData['name'],
            $dataContainer,
            $configHelp['epic'],
            $stories,
            $recap
        );
    }
}
