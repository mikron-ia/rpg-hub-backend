<?php

/**
 * Data file for 7th Sea RPG system, 1st edition
 * A creation of John Wick, published by Alderac Entertainment Group in 1999
 * http://www.alderac.com/7thsea/
 * No copyright infringement intended, no copyrighted content used
 */

return [
    'dataPatterns' => [
        'character' => [
            'advantages' => [], // traits - advantages & disadvantages
            'attributes' => [], // basic attributes
            'basics' => [], // names, descriptions, etc.
            'catches' => [], // catches: backgrounds, motivations... - NOTE: system specific; backgrounds here
            'contacts' => [], // friends & allies
            'damage' => [], // more permanent damage
            'defences' => [], // hit difficulties
            'descriptions' => [], // descriptions detailed
            'development' => [], // development history
            'equipment' => [], // items on person
            'expenses' => [], // regular expenses
            'income' => [], // regular income
            'languages' => [], // languages known
            'money' => [], // cash at hand
            'public' => [], // public information
            'professions' => [], // used together skill groups with skills
            'rolls' => [], // most commonly used rolls
            'skills' => [], // skills
            'stunts' => [], // one-of kind tricks - NOTE: should be renamed to techniques, this is not FATE
            'weapons' => [], // specific category of equipment - tools for combat, with additional parameters
            'variables' => [], // often changing values, like damage or drama counters
            'xp' => [], // experience
        ],
        'person' => [
            'name' => '',
            'descriptions' => [],
            'reputations' => [], // reputation values
            'reputationEvents' => [], // reputation history
            'tags' => [], // tags for grouping
            'tagline' => '', // line of description for index
        ],
        'group' => [
            'basics' => [], // names, descriptions, etc.
            'descriptions' => [], // descriptions detailed
            'public' => [], // public information
            'members' => [], // public information
            'absentMembers' => [], // public information
            'pastMembers' => [], // public information
            'membersReputations' => [], // public information
            'reputations' => [], // reputation values
            'reputationEvents' => [], // reputation history
        ],
        'epic' => [
            'basics' => [], // names, descriptions, etc.
            'current' => null,
            'stories' => [],
        ],
        'event' => [],
        'recap' => [
            'parameters' => [],
            'short' => "",
        ],
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
