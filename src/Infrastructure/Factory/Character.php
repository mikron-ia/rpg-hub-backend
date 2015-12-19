<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Entity;
use Mikron\HubBack\Domain\Exception\CharacterNotFoundException;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Storage\StorageForCharacter;

class Character
{
    public function createFromSingleArray($name, $storageData)
    {
        return new Entity\character($name, $storageData);
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
                $list[] = $this->createFromSingleArray($record['name'], $storageData);
            }
        }

        return $list;
    }

    /**
     * Retrieves character objects from database
     *
     * @param $connection
     * @return array
     */
    public function retrieveAllFromDb($connection)
    {
        $characterStorage = new StorageForCharacter($connection);

        $array = $characterStorage->retrieveAll();

        $list = [];

        if (!empty($array)) {
            foreach ($array as $record) {
                $storageData = new StorageIdentification($record['character_id'], null);
                $list[] = $this->createFromSingleArray($record['name'], null, $storageData);
            }
        }

        return $list;
    }

    public function retrieveCharacterFromDb($connection, $dbId)
    {
        $characterStorage = new StorageForCharacter($connection);

        $characterWrapped = $characterStorage->retrieve($dbId);

        if (!empty($characterWrapped)) {
            $characterUnwrapped = array_pop($characterWrapped);

            $storageData = new StorageIdentification($characterUnwrapped['character_id'], null);

            $character = $this->createFromSingleArray($characterUnwrapped['name'], null, $storageData);
        } else {
            throw new CharacterNotFoundException("Character with given ID has not been found in our database");
        }

        return $character;
    }
}
