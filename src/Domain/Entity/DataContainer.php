<?php

namespace Mikron\HubBack\Domain\Entity;

/**
 * Class DataContainer - class for all bag-like resources that are extras for the model, not represented it is normal structure
 * This container is intended to wrap module-delivered data, with assumption they are already correctly formatted (if JSON was correct)
 * This container should not be used for things that have their own entity models
 *
 * @package Mikron\HubBack\Domain\Entity
 */
class DataContainer
{
    private $data;

    /**
     * Character constructor.
     * @param $dataPattern array Labels with default values (most likely "" and [], dependent on type)
     * @param $inputData array Unpacked JSON to be put into mold
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
