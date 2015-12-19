<?php

use Mikron\HubBack\Domain\Entity\Person;

class PersonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctDataProvider
     * @param $name
     * @param $identification
     */
    function isNameCorrect($name, $identification)
    {
        $character = new Person($identification, $name);
        $this->assertEquals($name, $character->getName());
    }

    public function correctDataProvider()
    {
        return [
            [
                null,
                "Test Person",
            ]
        ];
    }
}
