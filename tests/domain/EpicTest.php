<?php

use Mikron\HubBack\Domain\Entity\DataContainer;
use Mikron\HubBack\Domain\Entity\Epic;
use Mikron\HubBack\Domain\Entity\Story;
use Mikron\HubBack\Infrastructure\Factory\DataContainer as DataContainerFactory;

final class EpicTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctDataProvider
     * @param $storage
     * @param $name
     * @param $data
     * @param $help
     */
    public function areStoriesCorrect($storage, $name, $data, $help)
    {
        $dataObject = (new DataContainerFactory())->createWithoutPattern($data);
        $epic = new Epic($storage, $name, $dataObject, $help, [], null);
        $this->assertContainsOnlyInstancesOf('\Mikron\HubBack\Domain\Entity\Story', $epic->getStories());
    }

    public function correctDataProvider()
    {
        return [
            [
                null,
                "Test Epic",
                [
                    'test0' => 'Test Data',
                    'test1' => 'Test Data',
                ],
                []
            ],
            [
                null,
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
