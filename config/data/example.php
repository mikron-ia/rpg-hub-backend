<?php

/**
 * Data file for example system
 * Copy and fill to wit with data you require
 */

return [
    'dataPatterns' => [
        'character' => [
            'advantages' => [], // traits - advantages & disadvantages
            'attributes' => [], // basic attributes
            'basics' => [], // names, descriptions, etc.
            'contacts' => [], // friends & allies
            'catches' => [], // catches: backgrounds, motivations...
            'damage' => [], // more permanent damage
            'descriptions' => [], // descriptions detailed
            'development' => [], // development history
            'equipment' => [], // items on person
            'expenses' => [], // regular expenses
            'income' => [], // regular income
            'money' => [], // cash at hand
            'public' => [], // public information
            'rolls' => [], // most commonly used rolls
            'skillGroups' => [], // thematic skill groups
            'skills' => [], // skills
            'stunts' => [], // one-of kind tricks
            'weapons' => [], // specific category of equipment - tools for combat
            'variables' => [], // often changing values, like counters
            'xp' => [], // experience
        ],
        'person' => [
            "name" => "", // name
            'descriptions' => [], // listing of descriptions
            'reputations' => [], // reputation values
            'reputationEvents' => [], // reputation history
            'tags' => [], // tags for grouping
            'tagline' => '', // line of description for index
        ],
        'group' => [
            'basics' => [], // names, descriptions, etc.
            'descriptions' => [], // descriptions detailed
            'public' => [], // public information
            'reputations' => [], // reputation values
            'reputationEvents' => [], // reputation history
        ],
        'epic' => [
            'basics' => [], // names, descriptions, etc.
            'current' => [],
            'stories' => [],
        ],
        'event' => [],
        'story' => [
            'parameters' => [],
            'short' => "",
            'long' => "",
        ],
    ],
    'help' => [
        'character' => [],
        'person' => [],
        'event' => [],
        'group' => [],
    ],
];
