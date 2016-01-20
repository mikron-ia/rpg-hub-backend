<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\RecapNotFoundException;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Storage\StorageForRecap;
use Psr\Log\LoggerInterface;

final class Recap
{
    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Entity\DataContainer|null $data
     * @param string[] $help
     * @return Entity\Recap
     */
    public function createFromSingleArray($identification, $name, $data, $help)
    {
        return new Entity\Recap($identification, $name, $data, $help);
    }

    /**
     * Creates recap objects from array
     *
     * @param $array
     * @return Recap[]
     */
    public function createFromCompleteArray($array)
    {
        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['recap_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name'], null, []);
            }
        }

        return $list;
    }

    /**
     * Retrieves recap objects from database
     *
     * @param $connection
     * @param $dataPatterns
     * @return Recap[]
     */
    public function retrieveAllFromDb($connection, $dataPatterns)
    {
        $recapStorage = new StorageForRecap($connection);

        $array = $recapStorage->retrieveAll();

        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['recap_id'], null);
                $list[] = $this->unwrapRecap($record, $dataPatterns, null, []);
            }
        }

        return $list;
    }

    /**
     * Retrieves a given recap from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param int $dbId
     * @return Entity\recap
     * @throws RecapNotFoundException
     */
    public function retrieveRecapFromDbById($connection, $dataPatterns, $help, $dbId)
    {
        $recapStorage = new StorageForRecap($connection);
        $recapWrapped = $recapStorage->retrieveById($dbId);

        return $this->unwrapRecap($recapWrapped, $dataPatterns, null, $help);
    }

    /**
     * Retrieves a given recap from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param string $key
     * @return Entity\recap
     * @throws RecapNotFoundException
     */
    public function retrieveRecapFromDbByKey($connection, $dataPatterns, $help, $key)
    {
        $recapStorage = new StorageForRecap($connection);
        $recapWrapped = $recapStorage->retrieveByKey($key);

        return $this->unwrapRecap($recapWrapped, $dataPatterns, null, $help);
    }

    /**
     * @param array $recapWrapped
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @param string[][] $help
     * @return Entity\Recap
     * @throws RecapNotFoundException
     * @todo DataContainer factory should be passed as DI with defined pattern?
     * @todo Consider methods for JSON and array separately
     */
    public function unwrapRecap($recapWrapped, $dataPatterns, $logger, $help)
    {
        if (!empty($recapWrapped)) {
            $recapUnwrapped = array_pop($recapWrapped);

            $storageData = new StorageIdentification($recapUnwrapped['recap_id'], $recapUnwrapped['key']);

            $dataContainerFactory = new DataContainer();
            $data = json_decode($recapUnwrapped['data'], true);
            $dataContainerForRecap = $dataContainerFactory->createWithPattern($data, $dataPatterns['recap']);

            $recap = $this->createFromSingleArray(
                $storageData,
                $recapUnwrapped['name'],
                $dataContainerForRecap,
                $help['recap']
            );
        } else {
            throw new RecapNotFoundException("Recap with given ID has not been found in our database");
        }

        return $recap;
    }

    public function retrieveMostRecent($connection, $dataPatterns, $help)
    {
        $recapStorage = new StorageForRecap($connection);
        $recapWrapped = $recapStorage->retrieveAll();
        $recapRecent = array_pop($recapWrapped);

        return $this->unwrapRecap([$recapRecent], $dataPatterns, null, $help);
    }
}
