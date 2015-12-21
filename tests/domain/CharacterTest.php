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
     * @param array $data
     * @param string[] $help
     * @param Person $person
     */
    function isNameCorrect($storage, $name, $data, $help, $person)
    {
        $dataFactory = new DataContainerFactory();
        $character = new Character($storage, $name, $dataFactory->createWithoutPattern($data), $help, $person);
        $this->assertEquals($name, $character->getName());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param StorageIdentification $storage
     * @param string $name
     * @param Person $person
     * @param array $data
     * @param string[] $help
     * @todo Test both type and content
     */
    function isPersonCorrect($storage, $name, $data, $help, $person)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $character = new Character($storage, $name, $dataObject, $help, $person);
        $this->assertEquals($person, $character->getPerson());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param StorageIdentification $storage
     * @param string $name
     * @param string[] $help
     * @param array $data
     * @param Person $person
     */
    function isDataCorrect($storage, $name, $help, $data, $person)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $character = new Character($storage, $name, $dataObject, $help, $person);
        $this->assertEquals($dataObject, $character->getData());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param StorageIdentification $storage
     * @param string $name
     * @param string[] $help
     * @param array $data
     * @param Person $person
     */
    function isHelpCorrect($storage, $name, $help, $data, $person)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $character = new Character($storage, $name, $dataObject, $help, $person);
        $this->assertEquals($help, $character->getHelp());
    }

    public function correctDataProvider()
    {
        return [
            [
                null,
                "Test Character",
                [
                    'test0' => 'Test Data',
                    'test1' => 'Test Data',
                ],
                [],
                null
            ]
        ];
    }
}
