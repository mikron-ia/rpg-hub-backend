<?php

use Mikron\HubBack\Domain\Entity\Group;
use Mikron\HubBack\Infrastructure\Factory\DataContainer as DataContainerFactory;

final class GroupTest extends PHPUnit_Framework_TestCase
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
        $group = new Group($this->identification, 'Test Name', null, []);
        $this->assertEquals($this->identification, $group->getIdentification());
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
        $character = new Group($this->identification, $name, $data, $help);
        $this->assertEquals($name, $character->getName());
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
        $group = new Group($this->identification, $name, $data, $help);
        $this->assertEquals($data, $group->getData());
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
        $group = new Group($this->identification, $name, $dataObject, $help);
        $this->assertEquals($help, $group->getHelp());
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
        $group = new Group($this->identification, $name, $dataObject, $help);
        $expected = [
            'name' => $group->getName(),
            'key' => $group->getKey(),
        ];

        $this->assertEquals($expected, $group->getSimpleData());
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
        $group = new Group($this->identification, $name, $dataObject, $help);

        $expectedSimple = [
            'name' => $group->getName(),
            'key' => $group->getKey(),
            'help' => $group->getHelp(),
        ];

        $expected = $expectedSimple + $group->getData()->getData();

        $this->assertEquals($expected, $group->getCompleteData());
    }

    public function correctDataProvider()
    {
        return [
            [
                "Test Group",
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
                "Test Group",
                [],
                [],
            ],
            [
                "Test Group",
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
