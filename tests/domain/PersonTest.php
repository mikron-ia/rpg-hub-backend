<?php

use Mikron\HubBack\Domain\Entity\Person;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Infrastructure\Factory\DataContainer as DataContainerFactory;

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
        $person = new Person($this->identification, 'Test Name', null);
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

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $data
     */
    function isDataCorrect($name,  $data)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person($this->identification, $name, $dataObject);
        $this->assertEquals($dataObject, $person->getData());
    }

    public function correctDataProvider()
    {
        return [
            [
                "Test Person",
                [
                    'test0' => 'Test Data',
                    'test1' => 'Test Data',
                ]
            ]
        ];
    }
}
