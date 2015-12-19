<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\CharacterNotFoundException;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Storage\StorageForCharacter;
use Psr\Log\LoggerInterface;

class Character
{
    public function createFromSingleArray($identification, $name, $person, $data)
    {
        return new Entity\Character($identification, $name, $person, $data);
    }

    /**
     * Creates character objects from array
     * @param $array
     * @return Character[]
     */
    public function createFromCompleteArray($array)
    {
        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['character_id'], null);
                $list[] = $this->createFromSingleArray($storageData, $record['name'], [], []);
            }
        }

        return $list;
    }

    /**
     * Retrieves character objects from database
     *
     * @param $connection
     * @return Character[]
     */
    public function retrieveAllFromDb($connection)
    {
        $characterStorage = new StorageForCharacter($connection);
        $array = $characterStorage->retrieveAll();

        $list = [];
        if (!empty($array)) {
            foreach ($array as $record) {
                $list[] = $this->unwrapCharacter($record, $connection, null);
            }
        }

        return $list;
    }

    /**
     * Retrieves single character from DB
     * @param $connection StorageEngine
     * @param $dbId int
     * @return Entity\Character
     * @throws CharacterNotFoundException
     */
    public function retrieveCharacterFromDb($connection, $dbId)
    {
        $characterStorage = new StorageForCharacter($connection);
        $characterWrapped = $characterStorage->retrieve($dbId);

        return $this->unwrapCharacter($characterWrapped, $connection, null);
    }

    /**
     * @param array $characterWrapped
     * @param StorageEngine $connection
     * @param LoggerInterface $logger
     * @return Entity\Person
     * @throws CharacterNotFoundException
     */
    public function unwrapCharacter($characterWrapped, $connection, $logger)
    {
        if (!empty($characterWrapped)) {
            $characterUnwrapped = array_pop($characterWrapped);

            $identification = new StorageIdentification($characterUnwrapped['character_id'], null);

            /* Get Person if ID is available */
            if (!empty($characterUnwrapped['person_id'])) {
                $personFactory = new Person();
                $person = $personFactory->retrievePersonFromDb($connection, $characterUnwrapped['person_id']);
            } else {
                $person = null;
            }

            $character = $this->createFromSingleArray($identification, $characterUnwrapped['name'], $person, []);
        } else {
            throw new CharacterNotFoundException("Character with given ID has not been found in our database");
        }

        return $character;
    }
}
