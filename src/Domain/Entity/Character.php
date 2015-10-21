<?php

namespace Mikron\HubBack\Domain\Entity;

/**
 * Class Character - abstract concepts that aggregates everything that makes a character
 * @package Mikron\HubBack\Domain\Entity
 */
class Character
{
    /**
     * @var Ego
     */
    private $ego;

    /**
     * @var string
     */
    private $name;

    /**
     * @var storageData
     */
    private $storageData;

    /**
     * Character constructor.
     * @param string $name
     * @param Ego|null $ego
     * @param StorageData|null $storageData
     */
    public function __construct($name, $ego, $storageData)
    {
        $this->name = $name;
        $this->ego = $ego;
        $this->storageData = $storageData;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
