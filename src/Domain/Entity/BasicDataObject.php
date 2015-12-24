<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Value\StorageIdentification;

/**
 * Class BasicDataObject - trait for standard things like name or help data
 * @package Mikron\HubBack\Domain\Entity
 */
abstract class BasicDataObject implements Displayable
{
    /**
     * @var StorageIdentification
     */
    protected $identification;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var DataContainer Unstructured data
     */
    protected $data;

    /**
     * @var string[] Help strings displayed on pages
     */
    protected $help;

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     */
    public function __construct($identification, $name, $data, array $help)
    {
        $this->name = $name;
        $this->identification = $identification;
        $this->data = $data;
        $this->help = $help;
    }

    /**
     * @return StorageIdentification
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return DataContainer
     */
    public function getData()
    {
        return $this->getDataAsObject();
    }

    /**
     * @return DataContainer
     */
    public function getDataAsObject()
    {
        return $this->data;
    }

    /**
     * @return DataContainer
     */
    public function getDataAsArray()
    {
        return $this->data->getData();
    }

    /**
     * @return \string[]
     */
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * @return string Key that identifies the object
     */
    public function getKey()
    {
        return $this->identification->getUuid();
    }

    /**
     * @return array Simple representation of the object content, fit for basic display
     */
    public function getSimpleData()
    {
        return [
            'name' => $this->getName(),
            'key' => $this->getKey(),
        ];
    }

    /**
     * @return array Complete representation of public parts of object content, fit for full card display
     */
    public function getCompleteData()
    {
        $basicData = [
            'name' => $this->getName(),
            'key' => $this->getKey(),
            'help' => $this->getHelp(),
        ];
        return $basicData + $this->getDataAsArray();
    }
}
