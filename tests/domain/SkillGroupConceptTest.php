<?php

use Mikron\HubBack\Domain\Entity\SkillGroup;
use Mikron\HubBack\Domain\Value\Code;
use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

class SkillGroupConceptTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @param $code
     * @param $name
     * @param $description
     */
    function isCodeCorrect($code, $name, $description)
    {
        $skillGroup = new SkillGroup($code, $name, $description);
        $this->assertEquals($name, $skillGroup->getName());
    }

    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @param $code
     * @param $name
     * @param $description
     */
    function isNameCorrect($code, $name, $description)
    {
        $skillGroup = new SkillGroup($code, $name, $description);
        $this->assertEquals($name, $skillGroup->getName());
    }

    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @param $code
     * @param $name
     * @param $description
     */
    function isDescriptionCorrect($code, $name, $description)
    {
        $skillGroup = new SkillGroup($code, $name, $description);
        $this->assertEquals($description, $skillGroup->getDescription());
    }

    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @depends      isNameCorrect
     * @param $code
     * @param $name
     * @param $description
     */
    function isSimpleDisplayCorrect($code, $name, $description)
    {
        $skillGroup = new SkillGroup($code, $name, $description);

        $expectation = [
            "name" => $skillGroup->getName()
        ];

        $this->assertEquals($expectation, $skillGroup->getSimpleData());
    }

    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @param $name
     * @param $description
     */
    function isComplexDisplayCorrect($code, $name, $description)
    {
        $skillGroup = new SkillGroup($code, $name, $description);

        $expectation = [
            "name" => $skillGroup->getName(),
            "description" => $skillGroup->getDescription()
        ];

        $this->assertEquals($expectation, $skillGroup->getCompleteData());
    }

    public function correctSkillDataProvider()
    {
        return [
            [
                new Code('active'),
                new Name(['en' => 'Active Skills', 'pl' => 'Umiej�tno�ci aktywne'], 'en'),
                new Description(['en' => 'Skills used for active tests'], 'en')
            ]
        ];
    }
}