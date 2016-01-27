<?php

/**
 * Data file for Laundry Files system
 * http://cubicle7.co.uk/our-games/the-laundry/
 * No copyright infringement intended, no copyrighted content used
 */

return [
    'dataPatterns' => [
        'character' => [
            'attributes' => [], // basic attributes
            'basics' => [], // names, descriptions, etc.
            'contacts' => [], // friends & allies
            'catches' => [], // catches: backgrounds, motivations...
            'descriptions' => [], // descriptions detailed
            'development' => [], // development history
            'equipment' => [], // items on person
            'public' => [], // public information
            'rolls' => [], // most commonly used rolls
            'sanityHistory' => [], // mind state history
            'skillGroups' => [], // thematic skill groups
            'skills' => [], // skills
            'weapons' => [], // specific category of equipment - tools for combat
            'variables' => [], // often changing values, like counters
        ],
        'person' => [
            'reputations' => [], // reputation values
            'reputationEvents' => [], // reputation history
            'indexText' => "", // helpful information to display on page
            'tags' => [], // tags for grouping
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
