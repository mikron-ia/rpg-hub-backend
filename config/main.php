<?php

return [
    'version' => '0.2-dev',
    'databaseReference' => [
        'mysql' => 'MySql',
        'mongodb' => 'MongoDb',
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
        'person' => [],
        'event' => [],
    ],

    'help' => [
        'character' => [],
        'person' => [],
        'event' => [],
    ],
];
