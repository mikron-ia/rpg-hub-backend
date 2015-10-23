<?php

namespace Mikron\HubBack\Domain\Blueprint;

use Mikron\HubBack\Domain\Exception\IncorrectConfigurationComponentException;

/**
 * Class Collection - simple collection system to aggregate Concepts and Entities
 * @package Mikron\HubBack\Domain\Blueprint
 */
abstract class Collection
{
    /**
     * @var Collectible[]
     */
    private $collection;

    /**
     * Collection constructor.
     * @param Collectible[] $collection
     * @throws IncorrectConfigurationComponentException
     */
    public function __construct($collection)
    {
        $this->collection = [];

        foreach ($collection as $collectionObject) {
            if (!($collectionObject instanceof Collectible)) {
                throw new IncorrectConfigurationComponentException("There is an object that is not a Collectible on the list");
            }

            $collectionObjectKey = $collectionObject->getKey();
            if ($collectionObjectKey !== null) {
                if ($this->isValid($collectionObject)) {
                    $this->collection[$collectionObjectKey] = $collectionObject;
                } else {
                    throw new IncorrectConfigurationComponentException("Object does not validate");
                }
            }
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->collection;
    }

    /**
     * @param $key
     * @return null
     */
    public function find($key)
    {
        return $this->findByIndex($key);
    }

    /**
     * @param $key
     * @return null
     */
    public function findByIndex($key)
    {
        if (isset($this->collection[$key])) {
            return $key;
        } else {
            return null;
        }
    }

    /**
     * @param $fieldName
     * @param $key
     * @return null
     */
    public function findByField($fieldName, $key)
    {
        foreach ($this->collection as $collectionObject) {
            if (isset($collectionObject[$fieldName]) && $collectionObject[$fieldName] === $key) {
                return $collectionObject;
            }
        }

        return null;
    }

    /**
     * @param $fieldName
     * @param $key
     * @return array
     */
    public function findAllByField($fieldName, $key)
    {
        $found = [];

        foreach ($this->collection as $collectionObject) {
            if (isset($collectionObject[$fieldName]) && $collectionObject[$fieldName] === $key) {
                $found[] = $collectionObject;
            }
        }

        return $found;
    }

    /**
     * @param Collectible $validatedObject
     * @return mixed
     */
    abstract protected function isValid($validatedObject);
}
