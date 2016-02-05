<?php

namespace Mikron\HubBack\Tests;

use Mikron\HubBack\Domain\Entity\DataContainer;
use PHPUnit_Framework_TestCase;

/**
 * Class DataContainerTest
 */
final class DataContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     * @param array $pattern
     * @param array $data
     * @param array $expectation
     */
    public function dataReturnedCorrectly($pattern, $data, $expectation)
    {
        $container = new DataContainer($pattern, $data);
        $this->assertEquals($expectation, $container->getData());
    }

    public function dataProvider()
    {
        return [
            [
                [],
                [],
                []
            ],
            [
                ['simpleKey' => ''],
                ['simpleKey' => 'simpleData'],
                ['simpleKey' => 'simpleData'],
            ],
            [
                [
                    'simpleKey0' => ''
                ],
                [
                    'simpleKey0' => 'simpleData0',
                    'simpleKey1' => 'simpleData1',
                ],
                [
                    'simpleKey0' => 'simpleData0'
                ],
            ],
            [
                [
                    'simpleKey0' => '',
                    'simpleKey1' => '',
                ],
                [
                    'simpleKey0' => 'simpleData0',
                ],
                [
                    'simpleKey0' => 'simpleData0',
                    'simpleKey1' => '',
                ],
            ],
            [
                [
                    'simpleKey0' => 'Default data',
                    'simpleKey1' => 'Default data',
                ],
                [
                    'simpleKey0' => 'simpleData0',
                ],
                [
                    'simpleKey0' => 'simpleData0',
                    'simpleKey1' => 'Default data',
                ],
            ],
        ];
    }
}
