<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Value;

/**
 * Class Descriptions - factory for Description and Description Pack
 * @package Mikron\HubBack\Infrastructure\Factory
 * @todo Add creation of DescriptionPack objects
 */
class Descriptions
{
    /**
     * @param string $title
     * @param string $code
     * @param string $publicText
     * @param string $secretText
     * @return Value\Description
     */
    public function createDescriptionFromBasicData($title, $code, $publicText, $secretText)
    {
        return new Value\Description($title, $code, $publicText, $secretText);
    }

    /**
     * @param array $record
     * @return Value\Description
     */
    public function createDescriptionFromDatabaseRecord($record)
    {
        return $this->createDescriptionFromBasicData(
            $record['title'],
            $record['code'],
            $record['public_text'],
            $record['private_text']
        );
    }

    /**
     * @param array $records
     * @return Value\Description[]
     */
    public function createDescriptionsFromDatabaseRecords(array $records)
    {
        $array = [];

        foreach($records as $record) {
            $array[] = $this->createDescriptionFromDatabaseRecord($record);
        }

        return $array;
    }
}
