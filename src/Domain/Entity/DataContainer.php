<?php

namespace Mikron\HubBack\Domain\Entity;

/**
 * Class DataContainer - class for all bag-like resources that are extras for the model, not represented it is normal structure
 * This should not be used for things that have their own entity models
 * @package Mikron\HubBack\Domain\Entity
 */
class DataContainer
{
    private $data;

    /**
     * Character constructor.
     * @param $dataPattern
     * @param $inputData
     */
    public function __construct($dataPattern, $inputData)
    {
        $this->data = $dataPattern;

        $attributeNamesList = $this->getProperties();

        foreach ($attributeNamesList as $attributeName) {
            if (isset($inputData[$attributeName])) {
                $this->data[$attributeName] = $inputData[$attributeName];
            }
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        $attributeNamesList = $this->getProperties();

        $attributes = [];

        foreach ($attributeNamesList as $attributeName) {
            $attributes[$attributeName] = $this->data[$attributeName];
        }

        return $attributes;
    }

    /**
     * @return string[]
     */
    private function getProperties()
    {
        return array_keys($this->data);
    }
}
