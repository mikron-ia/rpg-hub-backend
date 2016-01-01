<?php

/**
 * Class RetrieverTest
 */
final class RetrieverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function retrieveAsJson()
    {
        $array = [
            'name' => 'Alfa',
            'info' => ['Beta', 'Gamma'],
        ];
        $json = json_encode($array);
        $connection = $this->mockHttpSource($json);

        $retriever = new \Mikron\HubBack\Domain\Service\Retriever($connection, []);

        $this->assertEquals($json, $retriever->getDataAsJSON());
    }

    /**
     * @test
     */
    public function retrieveAsArray()
    {
        $array = [
            'name' => 'Alfa',
            'info' => ['Beta', 'Gamma'],
        ];
        $json = json_encode($array);
        $connection = $this->mockHttpSource($json);

        $retriever = new \Mikron\HubBack\Domain\Service\Retriever($connection, []);

        $this->assertEquals($array, $retriever->getDataAsArray());
    }

    /**
     * @test
     */
    public function failOnBadJson()
    {
        $connection = $this->mockHttpSource("bad JSON");
        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\InvalidDataException');

        new \Mikron\HubBack\Domain\Service\Retriever($connection, []);
    }

    private function mockHttpSource($return)
    {
        $mock = $this->getMockBuilder('\Mikron\HubBack\Domain\Blueprints\ConnectionToOutside')->setMethods(['retrieve'])->getMock();
        $mock->method('retrieve')->willReturn($return);

        return $mock;
    }
}

