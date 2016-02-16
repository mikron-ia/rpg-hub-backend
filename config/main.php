<?php

return [
    'version' => '0.4-dev',
    'databaseReference' => [
        'mysql' => 'MySql',
        'mongodb' => 'mongoDb',
    ],

    'authentication' => [
        'front' => [
            'allowedStrategies' => [],
            'settingsByStrategy' => []
        ],
        /*
         * This describes list of authentication ways, along with their class suffixes
         *
         * THIS PART SHOULD NOT BE CHANGED BY OTHER CONFIG FILES
         */
        'authenticationMethodReference' => [
            'auth-simple' => 'simple',
        ],
    ],

    'dataPatterns' => [
        'character' => [],
        'epic' => [],
        'event' => [],
        'group' => [],
        'person' => [],
        'recap' => [],
        'story' => [],
    ],

    'help' => [
        'character' => [],
        'epic' => [],
        'event' => [],
        'group' => [],
        'person' => [],
        'recap' => [],
        'story' => [],
    ],
];
