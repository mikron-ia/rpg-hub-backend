<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\PersonNotFoundException;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Storage\StorageForPerson;

class Person
{
    public function createFromSingleArray($identification, $name)
    {
        return new Entity\person($identification, $name);
    }

    /**
     * Creates person objects from array
     * @param $array
     * @return Person[]
     */
    public function createFromCompleteArray($array)
    {
        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['person_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name']);
            }
        }

        return $list;
    }

    /**
     * Retrieves person objects from database
     *
     * @param $connection
     * @return Person[]
     */
    public function retrieveAllFromDb($connection)
    {
        $personStorage = new StorageForPerson($connection);

        $array = $personStorage->retrieveAll();

        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['person_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name']);
            }
        }

        return $list;
    }

    /**
     * Retrieves a given person from the database
     *
     * @param $connection StorageEngine
     * @param $dbId
     * @return Entity\person
     * @throws PersonNotFoundException
     */
    public function retrievePersonFromDb($connection, $dbId)
    {
        $personStorage = new StorageForPerson($connection);

        $personWrapped = $personStorage->retrieve($dbId);

        if (!empty($personWrapped)) {
            $personUnwrapped = array_pop($personWrapped);

            $storageData = new StorageIdentification($personUnwrapped['person_id'], null);

            $person = $this->createFromSingleArray($storageData, $personUnwrapped['name']);
        } else {
            throw new PersonNotFoundException("Person with given ID has not been found in our database");
        }

        return $person;
    }
}
