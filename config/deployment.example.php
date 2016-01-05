<?php

return [
    'debug' => false,
    'dbEngine' => '',
    'mysql' => [
        'dbname' => '',
        'user' => '',
        'password' => '',
        'host' => '',
        'driver' => 'pdo_mysql',
        /* NOTE: Following appears to be necessary for correct UTF-8 database handling */
        'driverOptions' => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
    ],
    'source' => [],

    'authentication' => [
        'front' => [
            'allowedStrategies' => ['simple'],
            'settingsByStrategy' => [
                'simple' => [
                    'authenticationKey' => '[enter key]'
                ]
            ]
        ],
        'reputation' => [
            'allowedStrategies' => [],
            'settingsByStrategy' => []
        ],
    ],
];
