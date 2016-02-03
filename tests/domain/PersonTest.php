<?php

use Mikron\HubBack\Domain\Entity\Person;
use Mikron\HubBack\Domain\Value\DescriptionPack;
use Mikron\HubBack\Infrastructure\Factory\DataContainer as DataContainerFactory;

final class PersonTest extends PHPUnit_Framework_TestCase
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
        $person = new Person($this->identification, 'Test Name', null, [], new DescriptionPack([]), [], '');
        $this->assertEquals($this->identification, $person->getIdentification());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $dataArray
     * @param string[] $help
     */
    public function isNameCorrect($name, $dataArray, $help)
    {
        $data = (new DataContainerFactory())->createWithoutPattern($dataArray);
        $person = new Person($this->identification, $name, $data, $help, new DescriptionPack([]), [], '');
        $this->assertEquals($name, $person->getName());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $dataArray
     * @param string[] $help
     */
    public function isDataCorrect($name, $dataArray, $help)
    {
        $data = (new DataContainerFactory())->createWithoutPattern($dataArray);
        $person = new Person($this->identification, $name, $data, $help, new DescriptionPack([]), [], '');
        $this->assertEquals($data, $person->getData());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $data
     * @param string[] $help
     */
    public function isHelpCorrect($name, $data, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person($this->identification, $name, $dataObject, $help, new DescriptionPack([]), [], '');
        $this->assertEquals($help, $person->getHelp());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @depends      isNameCorrect
     * @param string $name
     * @param array $data
     * @param string[] $help
     */
    public function simpleDataIsCorrect($name, $data, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person($this->identification, $name, $dataObject, $help, new DescriptionPack([]), [], 'Test TagLine');
        $expected = [
            'name' => $person->getName(),
            'key' => $person->getKey(),
            'tags' => [],
            'tagline' => 'Test TagLine'
        ];

        $this->assertEquals($expected, $person->getSimpleData());
    }

    /**
     * @test
     * @depends      isNameCorrect
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $data
     * @param string[] $help
     */
    public function completeDataIsCorrect($name, $data, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person($this->identification, $name, $dataObject, $help, new DescriptionPack([]), [], 'Test TagLine');

        $expectedSimple = [
            'name' => $person->getName(),
            'key' => $person->getKey(),
            'help' => $person->getHelp(),
            'descriptions' => [],
            'tags' => [],
            'tagline' => 'Test TagLine'
        ];

        $expected = $expectedSimple + $person->getData()->getData();

        $this->assertEquals($expected, $person->getCompleteData());
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
                [
                    'basic' => 'Basic help',
                    'complex' => 'Complex help',
                ],
            ],
            [
                "Test Person",
                [],
                [],
            ],
            [
                "Test Person",
                [
                    'test0' => 'Test Data',
                    'test1' =>
                        [
                            'Test Data',
                            'Test Data'
                        ]
                ],
                [
                    'basic' => 'Basic help',
                    'complex' => 'Complex help',
                ],
            ],
        ];
    }
}
