<?php

use Mikron\HubBack\Domain\Entity\Character;

class CharacterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctDataProvider
     * @param $name
     * @param $storage
     */
    function isNameCorrect($name, $storage)
    {
        $character = new Character($storage, $name, [], []);
        $this->assertEquals($name, $character->getName());
    }

    public function correctDataProvider()
    {
        return [
            [
                null,
                "Test Character"
            ]
        ];
    }
}
