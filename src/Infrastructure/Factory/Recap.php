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
     * Creates person objects from array
     *
     * @param $array
     * @return Recap[]
     */
    public function createFromCompleteArray($array)
    {
        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['person_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name'], null, []);
            }
        }

        return $list;
    }

    /**
     * Retrieves person objects from database
     *
     * @param $connection
     * @param $dataPatterns
     * @return Recap[]
     */
    public function retrieveAllFromDb($connection, $dataPatterns)
    {
        $personStorage = new StorageForRecap($connection);

        $array = $personStorage->retrieveAll();

        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['person_id'], null);
                $list[] = $this->unwrapRecap($record, $dataPatterns, null, []);
            }
        }

        return $list;
    }

    /**
     * Retrieves a given person from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param int $dbId
     * @return Entity\person
     * @throws RecapNotFoundException
     */
    public function retrieveRecapFromDbById($connection, $dataPatterns, $help, $dbId)
    {
        $personStorage = new StorageForRecap($connection);
        $personWrapped = $personStorage->retrieveById($dbId);

        return $this->unwrapRecap($personWrapped, $dataPatterns, null, $help);
    }

    /**
     * Retrieves a given person from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param string $key
     * @return Entity\person
     * @throws RecapNotFoundException
     */
    public function retrieveRecapFromDbByKey($connection, $dataPatterns, $help, $key)
    {
        $personStorage = new StorageForRecap($connection);
        $personWrapped = $personStorage->retrieveByKey($key);

        return $this->unwrapRecap($personWrapped, $dataPatterns, null, $help);
    }

    /**
     * @param array $personWrapped
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @param string[][] $help
     * @return Entity\Recap
     * @throws RecapNotFoundException
     * @todo DataContainer factory should be passed as DI with defined pattern?
     * @todo Consider methods for JSON and array separately
     */
    public function unwrapRecap($personWrapped, $dataPatterns, $logger, $help)
    {
        if (!empty($personWrapped)) {
            $personUnwrapped = array_pop($personWrapped);

            $storageData = new StorageIdentification($personUnwrapped['person_id'], $personUnwrapped['key']);

            $dataContainerFactory = new DataContainer();
            $data = json_decode($personUnwrapped['data'], true);
            $dataContainerForRecap = $dataContainerFactory->createWithPattern($data, $dataPatterns['person']);

            $person = $this->createFromSingleArray(
                $storageData,
                $personUnwrapped['name'],
                $dataContainerForRecap,
                $help['person']
            );
        } else {
            throw new RecapNotFoundException("Recap with given ID has not been found in our database");
        }

        return $person;
    }
}
