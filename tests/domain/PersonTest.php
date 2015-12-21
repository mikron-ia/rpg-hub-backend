<?php

use Mikron\HubBack\Domain\Entity\Person;
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
        $person = new Person($this->identification, 'Test Name', null, []);
        $this->assertEquals($this->identification, $person->getIdentification());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $dataArray
     * @param string[] $help
     */
    function isNameCorrect($name, $dataArray, $help)
    {
        $data = (new DataContainerFactory())->createWithoutPattern($dataArray);
        $character = new Person($this->identification, $name, $data, $help);
        $this->assertEquals($name, $character->getName());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $dataArray
     * @param string[] $help
     */
    function isDataCorrect($name, $dataArray, $help)
    {
        $data = (new DataContainerFactory())->createWithoutPattern($dataArray);
        $person = new Person($this->identification, $name, $data, $help);
        $this->assertEquals($data, $person->getData());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param string[] $help
     * @param array $data
     */
    function isHelpCorrect($name, $help, $data)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person($this->identification, $name, $dataObject, $help);
        $this->assertEquals($help, $person->getHelp());
    }

    public function correctDataProvider()
    {
        return [
            [
                "Test Person",
                [
                    'test0' => 'Test Data',
                    'test1' => 'Test Data',
                ],
                [],
            ]
        ];
    }
}
