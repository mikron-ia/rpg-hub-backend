<?php

use Mikron\HubBack\Domain\Entity\Character;
use Mikron\HubBack\Domain\Entity\Person;
use Mikron\HubBack\Domain\Value\StorageIdentification;

class CharacterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctDataProvider
     * @param $storage StorageIdentification
     * @param $name string
     * @param $person Person
     * @param $data array
     */
    function isNameCorrect($storage, $name, $person, $data)
    {
        $character = new Character($storage, $name, $person, $data);
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
