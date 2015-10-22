<?php

/**
 * Data file for Eclipse Phase RPG system
 * http://eclipsephase.com/
 * Data used in accord with http://creativecommons.org/licenses/by-nc-sa/3.0/us/
 * Due to its licensing, this file does comply with limitations of content placed on this directory
 */

/* Reputation networks list */
$app['config.system.reputations'] = [
    "@" => [
        "name" => "@-list",
        "description" => "Autonomists: anarchists, Barsoomians, Extropians, Titanian, scum",
    ],
    "c" => [
        "name" => "CivicNet",
        "description" => "Hypercorps, Jovians, Lunars, Martians, Venusians",
    ],
    "e" => [
        "name" => "EcoWave",
        "description" => "nano-ecologists, preservationists, reclaimers",
    ],
    "f" => [
        "name" => "Fame",
        "description" => "Media: socialities, celebrities, glitterati",
    ],
    "g" => [
        "name" => "Guanxi",
        "description" => "Criminals",
    ],
    "r" => [
        "name" => "Research Network Associates",
        "description" => "Scientists: Argonauts, researchers, hypertechnologists",
    ],
    "x" => [
        "name" => "ExploreNet",
        "description" => "Gatecrashers",
    ],
    "m" => [
        "name" => "MilNet",
        "description" => "Mercenaries",
    ],
    "i" => [
        "name" => "The Eye",
        "description" => "Firewall",
        "restricted" => "Firewall members only",
    ],
    "u" => [
        "name" => "UltiNet",
        "description" => "Ultimates",
        "restricted" => "Ultimates only",
    ],
    "cc" => [
        "name" => "ConsortiumCortex",
        "description" => "Planetary Consortium Hypercorps and corporate-based habitats",
        "membership" => ["c"]
    ],
    "cm" => [
        "name" => "MorningstarMap",
        "description" => "Morningstar Constellation Hypercorps and corporate-based habitats",
        "membership" => ["c"]
    ],
    "cl" => [
        "name" => "LunarLagrangianNet",
        "description" => "Lunar-Lagrange habitats and organisations",
        "membership" => ["c"]
    ],
];

/* Skill groups used by the system */
$app['config.system.skillGroups'] = [
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

/* Skills used by the system */
$app['config.system.skills'] = [
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
