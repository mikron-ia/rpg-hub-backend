<?php

use Mikron\HubBack\Domain\Concept\Skill;
use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

class SkillConceptTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @param $name
     * @param $description
     */
    function isNameCorrect($name, $description)
    {
        $skill = new Skill($name, $description);
        $this->assertEquals($name, $skill->getName());
    }

    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @param $name
     * @param $description
     */
    function isDescriptionCorrect($name, $description)
    {
        $skill = new Skill($name, $description);
        $this->assertEquals($description, $skill->getDescription());
    }

    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @depends isNameCorrect
     * @param $name
     * @param $description
     */
    function isSimpleDisplayCorrect($name, $description)
    {
        $skill = new Skill($name, $description);

        $expectation = [
            "name" => $skill->getName()
        ];

        $this->assertEquals($expectation, $skill->getSimpleData());
    }

    /**
     * @test
     * @dataProvider correctSkillDataProvider
     * @param $name
     * @param $description
     */
    function isComplexDisplayCorrect($name, $description)
    {
        $skill = new Skill($name, $description);

        $expectation = [
            "name" => $skill->getName(),
            "description" => $skill->getDescription()
        ];

        $this->assertEquals($expectation, $skill->getCompleteData());
    }

    public function correctSkillDataProvider()
    {
        return [
            [
                new Name(['en' => 'Knowledge (Geography)'], 'en'),
                new Description(['en' => 'Lore regarding various landmarks on Mars'], 'en')
            ]
        ];
    }
}