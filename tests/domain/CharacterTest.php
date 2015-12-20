<?php

use Mikron\HubBack\Domain\Entity\Character;
use Mikron\HubBack\Domain\Entity\Person;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Factory\DataContainer as DataContainerFactory;

class CharacterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctDataProvider
     * @param StorageIdentification $storage
     * @param string $name
     * @param Person $person
     * @param array $data
     */
    function isNameCorrect($storage, $name, $person, $data)
    {
        $dataFactory = new DataContainerFactory();
        $character = new Character($storage, $name, $person, $dataFactory->createWithoutPattern($data));
        $this->assertEquals($name, $character->getName());
    }

    public function correctDataProvider()
    {
        return [
            [
                null,
                "Test Character",
                null,
                []
            ]
        ];
    }
}
