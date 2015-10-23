<?php

class CodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function isCodeCorrect()
    {
        $name = "Test Code";
        $code = new \Mikron\HubBack\Domain\Value\Code($name);
        $this->assertEquals($name, $code->getCode());
    }

    /**
     * @test
     */
    public function isEmptyCodeRecognised()
    {
        $this->setExpectedException("\\Mikron\\HubBack\\Domain\\Exception\\IncorrectConfigurationComponentException");
        new \Mikron\HubBack\Domain\Value\Code("");
    }
}
