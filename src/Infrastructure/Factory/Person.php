<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\PersonNotFoundException;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Storage\StorageForPerson;
use Psr\Log\LoggerInterface;

class Person
{
    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Entity\DataContainer|null $data
     * @return Entity\Person
     */
    public function createFromSingleArray($identification, $name, $data)
    {
        return new Entity\Person($identification, $name, $data);
    }

    /**
     * Creates person objects from array
     *
     * @param $array
     * @return Person[]
     */
    public function createFromCompleteArray($array)
    {
        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['person_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name'], null);
            }
        }

        return $list;
    }

    /**
     * Retrieves person objects from database
     *
     * @param $connection
     * @param $dataPatterns
     * @return Person[]
     */
    public function retrieveAllFromDb($connection, $dataPatterns)
    {
        $personStorage = new StorageForPerson($connection);

        $array = $personStorage->retrieveAll();

        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['person_id'], null);
                $list[] = $this->unwrapPerson($record, $dataPatterns, null);
            }
        }

        return $list;
    }

    /**
     * Retrieves a given person from the database
     *
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param $dbId
     * @return Entity\person
     * @throws PersonNotFoundException
     */
    public function retrievePersonFromDb($connection, $dataPatterns, $dbId)
    {
        $personStorage = new StorageForPerson($connection);
        $personWrapped = $personStorage->retrieve($dbId);

        return $this->unwrapPerson($personWrapped, $dataPatterns, null);
    }

    /**
     * @param array $personWrapped
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @return Entity\Person
     * @throws PersonNotFoundException
     * @todo Make $dataContainerForPerson use available data
     * @todo Factory should be passed as DI with correct data
     */
    public function unwrapPerson($personWrapped, $dataPatterns, $logger)
    {
        if (!empty($personWrapped)) {
            $personUnwrapped = array_pop($personWrapped);

            $storageData = new StorageIdentification($personUnwrapped['person_id'], null);

            $dataContainerFactory = new DataContainer();
            $dataContainerForPerson = $dataContainerFactory->createWithPattern([], $dataPatterns['person']);

            $person = $this->createFromSingleArray($storageData, $personUnwrapped['name'], $dataContainerForPerson);
        } else {
            throw new PersonNotFoundException("Person with given ID has not been found in our database");
        }

        return $person;
    }
}
