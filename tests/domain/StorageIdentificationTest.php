<?php

use Mikron\HubBack\Domain\Value\StorageIdentification;

class StorageIdentificationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function dbIdIsCorrect()
    {
        $identification = new StorageIdentification(1, "Test Key");
        $this->assertEquals(1, $identification->getDBId());
    }

    /**
     * @test
     */
    public function uuidIsCorrect()
    {
        $identification = new StorageIdentification(1, "Test Key");
        $this->assertEquals("Test Key", $identification->getUuid());
    }
}
