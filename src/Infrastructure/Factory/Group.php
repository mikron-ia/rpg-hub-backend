<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\GroupNotFoundException;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Storage\StorageForGroup;
use Psr\Log\LoggerInterface;

class Group
{
    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Entity\DataContainer|null $data
     * @param string[] $help
     * @return Entity\Group
     */
    public function createFromSingleArray($identification, $name, $data, $help)
    {
        return new Entity\Group($identification, $name, $data, $help);
    }

    /**
     * Creates group objects from array
     *
     * @param $array
     * @return Group[]
     */
    public function createFromCompleteArray($array)
    {
        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['group_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name'], null, []);
            }
        }

        return $list;
    }

    /**
     * Retrieves group objects from database
     *
     * @param $connection
     * @param $dataPatterns
     * @return Group[]
     */
    public function retrieveAllFromDb($connection, $dataPatterns)
    {
        $groupStorage = new StorageForGroup($connection);

        $array = $groupStorage->retrieveAll();

        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['group_id'], null);
                $list[] = $this->unwrapGroup($record, $dataPatterns, null, []);
            }
        }

        return $list;
    }

    /**
     * Retrieves a given group from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param int $dbId
     * @return Entity\group
     * @throws GroupNotFoundException
     */
    public function retrieveGroupFromDbById($connection, $dataPatterns, $help, $dbId)
    {
        $groupStorage = new StorageForGroup($connection);
        $groupWrapped = $groupStorage->retrieveById($dbId);

        return $this->unwrapGroup($groupWrapped, $dataPatterns, null, $help);
    }

    /**
     * Retrieves a given group from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param string $key
     * @return Entity\group
     * @throws GroupNotFoundException
     */
    public function retrieveGroupFromDbByKey($connection, $dataPatterns, $help, $key)
    {
        $groupStorage = new StorageForGroup($connection);
        $groupWrapped = $groupStorage->retrieveByKey($key);

        return $this->unwrapGroup($groupWrapped, $dataPatterns, null, $help);
    }

    /**
     * @param array $groupWrapped
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @param string[][] $help
     * @return Entity\Group
     * @throws GroupNotFoundException
     * @todo DataContainer factory should be passed as DI with defined pattern?
     * @todo Consider methods for JSON and array separately
     */
    public function unwrapGroup($groupWrapped, $dataPatterns, $logger, $help)
    {
        if (!empty($groupWrapped)) {
            $groupUnwrapped = array_pop($groupWrapped);

            $storageData = new StorageIdentification($groupUnwrapped['group_id'], $groupUnwrapped['key']);

            $dataContainerFactory = new DataContainer();
            $data = json_decode($groupUnwrapped['data'], true);
            $dataContainerForGroup = $dataContainerFactory->createWithPattern($data, $dataPatterns['group']);

            $group = $this->createFromSingleArray(
                $storageData,
                $groupUnwrapped['name'],
                $dataContainerForGroup,
                $help['group']
            );
        } else {
            throw new GroupNotFoundException("Group with given ID has not been found in our database");
        }

        return $group;
    }
}
