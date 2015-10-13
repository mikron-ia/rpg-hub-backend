<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application;

$apiPath = '/../api/';

require_once $apiPath.'config.php';
require_once $apiPath.'dic.php';
require_once $apiPath.'routes.php';
require_once $apiPath.'error.php';

$app->run();
