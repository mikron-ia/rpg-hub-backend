<?php

namespace Mikron\HubBack\Tests;

use Mikron\HubBack\Domain\Entity\DataContainer;
use Mikron\HubBack\Domain\Entity\Epic;
use Mikron\HubBack\Domain\Entity\Recap;
use Mikron\HubBack\Domain\Entity\Story;
use Mikron\HubBack\Infrastructure\Factory\DataContainer as DataContainerFactory;
use PHPUnit_Framework_TestCase;

final class EpicTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param string $name
     * @param array $data
     * @param string[] $help
     */
    public function isNameCorrect($name, $data, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $epic = new Epic(null, $name, $dataObject, $help, [], null);
        $this->assertEquals($name, $epic->getName());
    }

    /**
     * @test
     * @dataProvider correctDataProvider
     * @param $name
     * @param $data
     * @param $help
     */
    public function areStoriesCorrect($name, $data, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $recapObject = new Recap(null, 'Recap', new DataContainer([], []), $help, []);

        $epic = new Epic(null, $name, $dataObject, $help, [], $recapObject);
        $this->assertContainsOnlyInstancesOf('\Mikron\HubBack\Domain\Entity\Story', $epic->getStories());
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
        $recapObject = new Recap(null, 'Recap', new DataContainer([], []), $help, []);

        $epic = new Epic(null, $name, $dataObject, $help, [], $recapObject);
        $expected = [
            'name' => $epic->getName(),
            'key' => $epic->getKey(),
        ];

        $this->assertEquals($expected, $epic->getSimpleData());
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
        $recapObject = new Recap(null, 'Recap', new DataContainer([], []), $help, []);

        $epic = new Epic(null, $name, $dataObject, $help, [], $recapObject);

        $expectedSimple = [
            'name' => $epic->getName(),
            'key' => $epic->getKey(),
            'help' => $epic->getHelp(),
            'stories' => $epic->getStories(),
            'current' => $epic->getRecap()->getCompleteData()
        ];

        $expected = $expectedSimple + $epic->getData()->getData();

        $this->assertEquals($expected, $epic->getCompleteData());
    }

    public function correctDataProvider()
    {
        return [
            [
                "Test Epic",
                [
                    'test0' => 'Test Data',
                    'test1' => 'Test Data',
                ],
                []
            ],
            [
                "Test Epic",
                [
                    'test0' => 'Test Data',
                    'test1' => 'Test Data',
                ],
                [
                    new Story(null, "Test story 0", new DataContainer([], []), []),
                    new Story(null, "Test story 1", null, []),
                ]
            ],
        ];
    }
}
