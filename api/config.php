<?php

use Mikron\HubBack\Domain\Exception\MissingConfigurationComponentException;

$configPath = __DIR__ . '/../config/';

/* Level 0: main config */
$configMain = require($configPath . 'main.php');

/* Level 2: Specific story / epic; loaded first, as it determines choice of Level 1 config option */
if (file_exists($configPath . 'epic.php')) {
    $configEpic = require($configPath . 'epic.php');
}

/* Level 1: RPG system data; selected in epic */
if (isset($configEpic['system'])) {
    $path = $configPath . 'data/' . $configEpic['system'] . '.php';
    if (file_exists($path)) {
        $configSystem = require($path);
    } else {
        throw new MissingConfigurationComponentException(
            'Config file not found"',
            'Data file for system coded "' . $configEpic['system'] . '" not found"'
        );
    }
}

/* Level 3: DB connectivity and other per-deployment issues */
if (file_exists($configPath . 'deployment.php')) {
    $configDeploy = require($configPath . 'deployment.php');
}

$app['config'] = array_replace_recursive($configMain, $configSystem, $configEpic, $configDeploy);
