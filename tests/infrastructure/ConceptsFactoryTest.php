<?php

use Mikron\HubBack\Infrastructure\Factory\ConceptsFactory;

class ConceptsFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConceptsFactory
     */
    private $factory;

    private $skillGroupPayload;
    private $skillPayload;

    protected function setUp()
    {
        $this->factory = new ConceptsFactory();
        $this->skillGroupPayload = [
            [
                "code" => "active",
                "name" => [
                    "en" => "Active skills",
                    "pl" => "Umiejętności aktywne"
                ],
                "description" => [
                    "en" => "Skills that are mainly concerned with direct actions. Every skill is either active or knowledge skill"
                ],
            ],
            [
                "code" => "knowledge",
                "name" => [
                    "en" => "Knowledge skills",
                    "pl" => "Umiejętności wiedzowe"
                ],
                "description" => [
                    "en" => "Skills that are mainly knowledge or lore. Every skill is either active or knowledge skill"
                ],
            ],
            [
                "code" => "social",
                "name" => [
                    "en" => "Social skills",
                    "pl" => "Umiejętności społeczne"
                ],
                "description" => [
                    "en" => "Skills concerned with interaction with living or thinking beings"
                ],
            ]
        ];

        $this->skillPayload = [
            [
                "code" => "animal-handling",
                "name" => [
                    "en" => "Animal Handling"
                ],
                "description" => [
                    "en" => "What it is: Skilled animal handlers are able to train and control a wide variety of natural and transgenic animals, including partial uplifts. Though many animal species went extinct during the Fall, a few “ark” and zoo habitats keep some species alive, and many others can be resurrected from genetic samples. Exotic animals are considered a sign of prestige among the hypercorp elites, and guard animals are occasionally used to protect high-security installations. Likewise, many habitats and settlements employ small armies of partially uplifted, genetically modified, and behavior-controlled creatures for sanitation or other purposes. Many new and strange breeds of animal are created daily to serve a variety of roles.
When you use it: Animal Handling is used whenever you are trying to manipulate an animal, whether your intent is to calm it down, keep it from attacking, intimidate it, acquire its trust, or goad it into attacking. Your Margin of Success determines how effective you are at convincing the creature. At the gamemaster’s discretion, modifiers may be applied to the test. Likewise, winning an animal over may sometimes take time, and so could be handled as a Task Action with a timeframe of five minutes or more.
Specializations: Per animal species (dogs, horses, smart rats, etc.)
Training animals: Training animals is a time-consuming task requiring repeated efforts and rewards to reinforce the trained behavior. Treat this as a Task Action with a timeframe of one day to one month, depending on the complexity of the action. Apply modifiers to this test based on the relative intelligence of the animal being trained, how domestic it is, and the complexity of the task. Once an animal has been trained, commanding it is treated as a Simple Success Test except for unusual or stressful situations, in which case the trainer receives a +30 modifier on their Animal Handling Tests when convincing the animal to complete the trained action."
                ],
                "groups" => [
                    "active", "social"
                ],
            ]
        ];
    }

    /**
     * @test
     */
    public function skillCreationFromArrayReturnsSkill()
    {
        $skillGroupCollection = $this->factory->createSkillGroupCollectionFromList($this->skillGroupPayload);

        $payload = [
            "code" => "animal-handling",
            "name" => [
                "en" => "Animal Handling"
            ],
            "description" => [
                "en" => "What it is: Skilled animal handlers are able to train and control a wide variety of natural and transgenic animals, including partial uplifts. Though many animal species went extinct during the Fall, a few “ark” and zoo habitats keep some species alive, and many others can be resurrected from genetic samples. Exotic animals are considered a sign of prestige among the hypercorp elites, and guard animals are occasionally used to protect high-security installations. Likewise, many habitats and settlements employ small armies of partially uplifted, genetically modified, and behavior-controlled creatures for sanitation or other purposes. Many new and strange breeds of animal are created daily to serve a variety of roles.
When you use it: Animal Handling is used whenever you are trying to manipulate an animal, whether your intent is to calm it down, keep it from attacking, intimidate it, acquire its trust, or goad it into attacking. Your Margin of Success determines how effective you are at convincing the creature. At the gamemaster’s discretion, modifiers may be applied to the test. Likewise, winning an animal over may sometimes take time, and so could be handled as a Task Action with a timeframe of five minutes or more.
Specializations: Per animal species (dogs, horses, smart rats, etc.)
Training animals: Training animals is a time-consuming task requiring repeated efforts and rewards to reinforce the trained behavior. Treat this as a Task Action with a timeframe of one day to one month, depending on the complexity of the action. Apply modifiers to this test based on the relative intelligence of the animal being trained, how domestic it is, and the complexity of the task. Once an animal has been trained, commanding it is treated as a Simple Success Test except for unusual or stressful situations, in which case the trainer receives a +30 modifier on their Animal Handling Tests when convincing the animal to complete the trained action."
            ],
            "groups" => [
                "active", "social"
            ],
        ];

        $skill = $this->factory->createSkillFromArray($payload, $skillGroupCollection);

        $this->assertInstanceOf("Mikron\\HubBack\\Domain\\Concept\\Skill", $skill);
    }

    /**
     * @test
     */
    public function skillCreationFromArrayReactsToIncompleteSkillGroup()
    {
        $skillGroupCollection = $this->factory->createSkillGroupCollectionFromList([]);

        $this->setExpectedException("\\Mikron\\HubBack\\Domain\\Exception\\IncorrectConfigurationComponentException");
        $this->factory->createSkillFromArray($this->skillPayload[0], $skillGroupCollection);
    }

    /**
     * @test
     */
    public function skillGroupCreationFromArrayReturnsSkillGroup()
    {
        $payload = [
            "code" => "social",
            "name" => [
                "en" => "Social skills",
                "pl" => "Umiejętności społeczne"
            ],
            "description" => [
                "en" => "Skills concerned with interaction with living or thinking beings"
            ],
        ];

        $skillGroup = $this->factory->createSkillGroupFromArray($payload);

        $this->assertInstanceOf("Mikron\\HubBack\\Domain\\Concept\\SkillGroup", $skillGroup);
    }

    /**
     * @test
     */
    public function skillGroupCollectionIsCreated()
    {
        $skillGroupCollection = $this->factory->createSkillGroupCollectionFromList($this->skillPayload);

        $this->assertInstanceOf("Mikron\\HubBack\\Domain\\Concept\\SkillGroupCollection", $skillGroupCollection);
    }
}
