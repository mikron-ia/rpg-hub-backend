<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\PersonNotFoundException;
use Mikron\HubBack\Domain\Value\DescriptionPack;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Domain\Value\Tag;
use Mikron\HubBack\Infrastructure\Storage\StorageForPerson;
use Psr\Log\LoggerInterface;

class Person
{
    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Entity\DataContainer|null $data
     * @param string[] $help
     * @param DescriptionPack $descriptions
     * @param Tag[] $tags
     * @param string $tagLine
     * @param string $visibility
     * @return Entity\Person
     */
    public function createFromSingleArray(
        $identification,
        $name,
        $data,
        $help,
        $descriptions,
        $tags,
        $tagLine,
        $visibility
    ) {
        return new Entity\Person($identification, $name, $data, $help, $descriptions, $tags, $tagLine, $visibility);
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
                $list[] = $this->createFromSingleArray(
                    $storageData,
                    $record['name'],
                    null,
                    [],
                    new DescriptionPack([]),
                    [],
                    '',
                    'linked' /* This is arbitrary */
                );
            }
        }

        return $list;
    }

    /**
     * Retrieves person objects from database
     *
     * @param StorageEngine $connection
     * @param $dataPatterns
     * @param string[][] $help
     * @param LoggerInterface $logger
     * @return Entity\Person[]
     * @throws PersonNotFoundException
     */
    public function retrieveAllFromDb($connection, $dataPatterns, $help, $logger)
    {
        $personStorage = new StorageForPerson($connection);
        $arrayOfPeople = $personStorage->retrieveAll();
        return $this->listForRetrieveAll($arrayOfPeople, $dataPatterns, $help, $logger);
    }

    /**
     * Retrieves person objects from database
     *
     * @param StorageEngine $connection
     * @param $dataPatterns
     * @param string[][] $help
     * @param LoggerInterface $logger
     * @return Entity\Person[]
     * @throws PersonNotFoundException
     */
    public function retrieveAllVisibleFromDb($connection, $dataPatterns, $help, $logger)
    {
        $personStorage = new StorageForPerson($connection);
        $arrayOfPeople = $personStorage->retrieveAllByVisibility(Entity\Person::VISIBILITY_FULL);
        return $this->listForRetrieveAll($arrayOfPeople, $dataPatterns, $help, $logger);
    }

    /**
     * @param array $arrayOfPeople
     * @param $dataPatterns
     * @param string[][] $help
     * @param LoggerInterface $logger
     * @return Person[]
     * @throws PersonNotFoundException
     */
    private function listForRetrieveAll(array $arrayOfPeople, $dataPatterns, $help, $logger)
    {
        $list = [];
        if (!empty($arrayOfPeople)) {
            foreach ($arrayOfPeople as $record) {
                $list[] = $this->unwrapPerson([$record], $dataPatterns, $logger, $help);
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
     * @throws PersonNotFoundException
     */
    public function retrievePersonFromDbById($connection, $dataPatterns, $help, $dbId)
    {
        $personStorage = new StorageForPerson($connection);
        $personWrapped = $personStorage->retrieveById($dbId);
        return $this->unwrapPerson($personWrapped, $dataPatterns, null, $help);
    }

    /**
     * Retrieves a given person from the database
     *
     * @param StorageEngine $connection
     * @param $dataPatterns
     * @param string[][] $help
     * @param string $key
     * @return Entity\person
     * @throws PersonNotFoundException
     */
    public function retrievePersonFromDbByKey($connection, $dataPatterns, $help, $key)
    {
        $personStorage = new StorageForPerson($connection);
        $personWrapped = $personStorage->retrieveByKey($key);
        return $this->unwrapPerson($personWrapped, $dataPatterns, null, $help);
    }

    /**
     * @param array $personWrapped
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @param string[][] $help
     * @return Entity\Person
     * @throws PersonNotFoundException
     * @todo DataContainer factory should be passed as DI with defined pattern?
     * @todo Consider methods for JSON and array separately
     */
    public function unwrapPerson($personWrapped, $dataPatterns, $logger, $help)
    {
        if (!empty($personWrapped)) {
            $personUnwrapped = array_pop($personWrapped);

            $storageData = new StorageIdentification($personUnwrapped['person_id'], $personUnwrapped['key']);

            $dataContainerFactory = new DataContainer();
            $data = json_decode($personUnwrapped['data'], true);
            $dataContainerForPerson = $dataContainerFactory->createWithPattern($data, $dataPatterns['person']);

            $person = $this->createFromSingleArray(
                $storageData,
                $personUnwrapped['name'],
                $dataContainerForPerson,
                $help['person'],
                new DescriptionPack([]), /* descriptions not retrieved from DB */
                [], /* tags not retrieved from DB */
                $personUnwrapped['tagline'],
                $personUnwrapped['visibility']
            );
        } else {
            throw new PersonNotFoundException("Person with given ID has not been found in our database");
        }

        return $person;
    }
}
