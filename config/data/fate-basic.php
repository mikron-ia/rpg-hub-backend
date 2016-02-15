<?php

/**
 * Data file for base FATE CORE system
 * http://www.faterpg.com/
 * FATE is a trademark of Evil Hat Productions, LLC.
 */

return [
    'dataPatterns' => [
        'character' => [
            'aspects' => [], // core of FATE
            'basics' => [], // names, descriptions, etc.
            'catches' => [], // catches: backgrounds, motivations...
            'consequences' => [], // more permanent damage
            'descriptions' => [], // descriptions detailed
            'development' => [], // development history
            'extras' => [], // regular expenses
            'public' => [], // public information
            'skills' => [], // skills
            'stunts' => [], // one-of kind tricks
            'variables' => [], // often changing values, like counters
            'xp' => [], // experience
        ],
        'person' => [
            "name" => "", // name
            'descriptions' => [], // listing of descriptions
            'tags' => [], // tags for grouping
            'tagline' => '', // line of description for index
        ],
        'group' => [
            'basics' => [], // names, descriptions, etc.
            'descriptions' => [], // descriptions detailed
            'public' => [], // public information
        ],
        'event' => [],
    ],
    'help' => [
        'character' => [],
        'person' => [],
        'event' => [],
        'group' => [],
    ],
];
