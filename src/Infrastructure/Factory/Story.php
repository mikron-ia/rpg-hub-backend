<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\StoryNotFoundException;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Storage\StorageForStory;
use Psr\Log\LoggerInterface;

class Story
{
    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Entity\DataContainer|null $data
     * @param string[] $help
     * @return Entity\Story
     */
    public function createFromSingleArray($identification, $name, $data, $help)
    {
        return new Entity\Story($identification, $name, $data, $help);
    }

    /**
     * Creates story objects from array
     *
     * @param $array
     * @return Story[]
     */
    public function createFromCompleteArray($array)
    {
        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['story_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name'], null, []);
            }
        }

        return $list;
    }

    /**
     * Retrieves story objects from database
     *
     * @param $connection
     * @param array $dataPatterns
     * @param string[][] $help
     * @return Entity\Story[]
     * @throws StoryNotFoundException
     */
    public function retrieveAllFromDb($connection, $dataPatterns, $help)
    {
        $storyStorage = new StorageForStory($connection);

        $array = $storyStorage->retrieveAll();

        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['story_id'], null);
                $list[] = $this->unwrapStory([$record], $dataPatterns, null, $help);
            }
        }

        return $list;
    }

    /**
     * Retrieves a given story from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param int $dbId
     * @return Entity\story
     * @throws StoryNotFoundException
     */
    public function retrieveStoryFromDbById($connection, $dataPatterns, $help, $dbId)
    {
        $storyStorage = new StorageForStory($connection);
        $storyWrapped = $storyStorage->retrieveById($dbId);

        return $this->unwrapStory($storyWrapped, $dataPatterns, null, $help);
    }

    /**
     * Retrieves a given story from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param string $key
     * @return Entity\story
     * @throws StoryNotFoundException
     */
    public function retrieveStoryFromDbByKey($connection, $dataPatterns, $help, $key)
    {
        $storyStorage = new StorageForStory($connection);
        $storyWrapped = $storyStorage->retrieveByKey($key);

        return $this->unwrapStory($storyWrapped, $dataPatterns, null, $help);
    }

    /**
     * @param array $storyWrapped
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @param string[][] $help
     * @return Entity\Story
     * @throws StoryNotFoundException
     * @todo DataContainer factory should be passed as DI with defined pattern?
     * @todo Consider methods for JSON and array separately
     */
    public function unwrapStory($storyWrapped, $dataPatterns, $logger, $help)
    {
        if (!empty($storyWrapped)) {
            $storyUnwrapped = array_pop($storyWrapped);

            $storageData = new StorageIdentification($storyUnwrapped['story_id'], $storyUnwrapped['key']);

            $dataContainerFactory = new DataContainer();
            $data = json_decode($storyUnwrapped['data'], true);
            $dataContainerForStory = $dataContainerFactory->createWithPattern($data, $dataPatterns['story']);

            $story = $this->createFromSingleArray(
                $storageData,
                $storyUnwrapped['name'],
                $dataContainerForStory,
                $help['story']
            );
        } else {
            throw new StoryNotFoundException("Story with given ID has not been found in our database");
        }

        return $story;
    }
}
