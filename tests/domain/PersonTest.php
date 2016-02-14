<?php

namespace Mikron\HubBack\Tests;

use Mikron\HubBack\Domain\Entity\Person;
use Mikron\HubBack\Domain\Value\DescriptionPack;
use Mikron\HubBack\Domain\Value\Tag;
use Mikron\HubBack\Infrastructure\Factory\DataContainer as DataContainerFactory;
use Mikron\HubBack\Infrastructure\Factory\StorageIdentification;
use PHPUnit_Framework_TestCase;

final class PersonTest extends PHPUnit_Framework_TestCase
{
    private $identification;

    protected function setUp()
    {
        $idFactory = new StorageIdentification();
        $this->identification = $idFactory->createFromData(1, 'Test Key');
    }

    /**
     * @test
     */
    public function identificationIsCorrect()
    {
        $person = new Person($this->identification, 'Test Name', null, [], new DescriptionPack([]), [], '',
            Person::VISIBILITY_LINK);
        $this->assertEquals($this->identification, $person->getIdentification());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $dataArray
     * @param Tag[] $tags
     * @param string[] $help
     * @return Person
     */
    public function isPersonCreatedCorrectly($name, $dataArray, $tags, $help)
    {
        $data = (new DataContainerFactory())->createWithoutPattern($dataArray);
        $person = new Person($this->identification, $name, $data, $help, new DescriptionPack([]), $tags, '',
            Person::VISIBILITY_LINK);

        $this->assertInstanceOf('Mikron\HubBack\Domain\Entity\Person', $person);
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $dataArray
     * @param Tag[] $tags
     * @param string[] $help
     */
    public function isNameCorrect($name, $dataArray, $tags, $help)
    {
        $data = (new DataContainerFactory())->createWithoutPattern($dataArray);
        $person = new Person($this->identification, $name, $data, $help, new DescriptionPack([]), $tags, '',
            Person::VISIBILITY_LINK);
        $this->assertEquals($name, $person->getName());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $dataArray
     * @param Tag[] $tags
     * @param string[] $help
     */
    public function isDataCorrect($name, $dataArray, $tags, $help)
    {
        $data = (new DataContainerFactory())->createWithoutPattern($dataArray);
        $person = new Person($this->identification, $name, $data, $help, new DescriptionPack([]), $tags, '',
            Person::VISIBILITY_LINK);
        $this->assertEquals($data, $person->getData());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $data
     * @param Tag[] $tags
     * @param string[] $help
     */
    public function isHelpCorrect($name, $data, $tags, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person($this->identification, $name, $dataObject, $help, new DescriptionPack([]), $tags, '',
            Person::VISIBILITY_LINK);
        $this->assertEquals($help, $person->getHelp());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @depends      isNameCorrect
     * @param string $name
     * @param array $data
     * @param Tag[] $tags
     * @param string[] $help
     */
    public function simpleDataIsCorrect($name, $data, $tags, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person(
            $this->identification,
            $name,
            $dataObject,
            $help,
            new DescriptionPack([]),
            $tags,
            'Test TagLine',
            Person::VISIBILITY_LINK
        );
        $expected = [
            'name' => $person->getName(),
            'key' => $person->getKey(),
            'tags' => $person->getTagsAsText(),
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
     * @param Tag[] $tags
     * @param string[] $help
     */
    public function completeDataIsCorrect($name, $data, $tags, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $person = new Person(
            $this->identification,
            $name,
            $dataObject,
            $help,
            new DescriptionPack([]),
            $tags,
            'Test TagLine',
            Person::VISIBILITY_LINK
        );

        $expectedSimple = [
            'name' => $person->getName(),
            'key' => $person->getKey(),
            'help' => $person->getHelp(),
            'descriptions' => [],
            'tags' => $person->getTagsAsText(),
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
                    new Tag('testTag0', ''),
                    new Tag('testTag1', '')
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
                    new Tag('testTag0', ''),
                    new Tag('testTag1', '')
                ],
                [
                    'basic' => 'Basic help',
                    'complex' => 'Complex help',
                ],
            ],
        ];
    }
}
