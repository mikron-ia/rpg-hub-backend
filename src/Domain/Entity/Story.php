<?php

namespace Mikron\HubBack\Domain\Entity;

/**
 * Class Story
 * @package Mikron\HubBack\Domain\Entity
 */
final class Story extends BasicDataObject
{
    public function getSimpleData()
    {
        $dataFromDataObject = $this->getDataAsArray();
        $dataForDisplay = [
            'parameters' => isset($dataFromDataObject['parameters'])?$dataFromDataObject['parameters']:[],
            'short' => isset($dataFromDataObject['short'])?$dataFromDataObject['short']:[],
        ];

        return array_merge_recursive(parent::getSimpleData(), $dataForDisplay);
    }
}
