<?php

$app->get('/', function (Silex\Application $app) {
    $output = new \Mikron\HubBack\Domain\Service\Output(
        "Front page",
        "This is basic front page. Please choose a functionality you wish to access from 'content' area",
        []
    );

    return $app->json($output->getArrayForJson());
});
