<?php

use Mikron\HubBack\Domain\Entity\Character;
use Mikron\HubBack\Domain\Entity\Ego;

class CharacterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctDataProvider
     * @param $name
     */
    function isNameCorrect($name, $ego, $storage)
    {
        $character = new Character($name, $ego, $storage);
        $this->assertEquals($name, $character->getName());
    }

    public function correctDataProvider()
    {
        return [
            [
                "Test Character",
                new Ego(),
                null
            ]
        ];
    }
}