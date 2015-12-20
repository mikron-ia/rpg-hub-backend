<?php

use Mikron\HubBack\Domain\Entity\Person;

class PersonTest extends PHPUnit_Framework_TestCase
{
    private $identification;

    protected function setUp()
    {
        $idFactory = new \Mikron\HubBack\Infrastructure\Factory\StorageIdentification();
        $this->identification = $idFactory->createFromData(1, 'Test Key');
    }

    /**
     * @test
     */
    public function identificationIsCorrect()
    {
        $person = new Person($this->identification, 'Test Name', []);
        $this->assertEquals($this->identification, $person->getIdentification());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param $name
     * @param $data
     */
    function isNameCorrect($name, $data)
    {
        $character = new Person($this->identification, $name, $data);
        $this->assertEquals($name, $character->getName());
    }

    public function correctDataProvider()
    {
        return [
            [
                "Test Person",
                []
            ]
        ];
    }
}
