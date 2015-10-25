<?php

use Mikron\HubBack\Domain\Entity\SkillGroup;
use Mikron\HubBack\Domain\Value\Code;
use Mikron\HubBack\Domain\Value\Description;
use Mikron\HubBack\Domain\Value\Name;

class SkillGroupConceptTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctSkillGroupDataProvider
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
     * @dataProvider correctSkillGroupDataProvider
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
     * @dataProvider correctSkillGroupDataProvider
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
     * @dataProvider correctSkillGroupDataProvider
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
     * @dataProvider correctSkillGroupDataProvider
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

    public function correctSkillGroupDataProvider()
    {
        return [
            [
                new Code('active'),
                new Name(['en' => 'Active Skills', 'pl' => 'Umiejętności aktywne'], 'en'),
                new Description(['en' => 'Skills used for active tests'], 'en')
            ]
        ];
    }
}
