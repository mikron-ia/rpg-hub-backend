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
    /**
     * Creates character object from array
     *
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param Entity\DataContainer $data
     * @param string[] $help
     * @param Entity\Person|null $person
     * @return Entity\Character
     */
    public function createFromSingleArray($identification, $name, $data, $help, $person)
    {
        return new Entity\Character($identification, $name, $data, $help, $person);
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
                $list[] = $this->createFromSingleArray($storageData, $record['name'], null, [], null);
            }
        }

        return $list;
    }

    /**
     * Retrieves character objects from database
     *
     * @param StorageEngine $connection
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @return Character[]
     * @throws CharacterNotFoundException
     */
    public function retrieveAllFromDb($connection, $dataPatterns, $help, $logger)
    {
        $characterStorage = new StorageForCharacter($connection);
        $array = $characterStorage->retrieveAll();

        $list = [];
        if (!empty($array)) {
            foreach ($array as $record) {
                $list[] = $this->unwrapCharacter($record, $connection, $dataPatterns, $logger, $help);
            }
        }

        return $list;
    }

    /**
     * Retrieves single character from DB
     * @param $connection StorageEngine
     * @param $dataPatterns
     * @param string[][] $help
     * @param $dbId int
     * @return Entity\Character
     * @throws CharacterNotFoundException
     */
    public function retrieveCharacterFromDb($connection, $dataPatterns, $help, $dbId)
    {
        $characterStorage = new StorageForCharacter($connection);
        $characterWrapped = $characterStorage->retrieve($dbId);

        return $this->unwrapCharacter($characterWrapped, $connection, $dataPatterns, null, $help);
    }

    /**
     * @param array $characterWrapped
     * @param StorageEngine $connection
     * @param array $dataPatterns
     * @param LoggerInterface $logger
     * @param string[][] $help
     * @return Entity\Person
     * @throws CharacterNotFoundException
     * @todo Make $dataContainerForCharacter use available data
     * @todo Factory should be passed as DI with correct data
     */
    public function unwrapCharacter($characterWrapped, $connection, $dataPatterns, $logger, $help)
    {
        if (!empty($characterWrapped)) {
            $characterUnwrapped = array_pop($characterWrapped);

            $identification = new StorageIdentification($characterUnwrapped['character_id'], null);

            /* Get Person if ID is available */
            if (!empty($characterUnwrapped['person_id'])) {
                $personFactory = new Person();
                $person = $personFactory->retrievePersonFromDb(
                    $connection,
                    $dataPatterns,
                    $help,
                    $characterUnwrapped['person_id']
                );
            } else {
                $person = null;
            }

            $dataContainerFactory = new DataContainer();
            $dataContainerForCharacter = $dataContainerFactory->createWithPattern([], $dataPatterns['character']);

            $character = $this->createFromSingleArray(
                $identification,
                $characterUnwrapped['name'],
                $dataContainerForCharacter,
                $help['character'],
                $person
            );
        } else {
            throw new CharacterNotFoundException("Character with given ID has not been found in our database");
        }

        return $character;
    }
}
