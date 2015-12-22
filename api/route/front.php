<?php

$app->get('/', function (Silex\Application $app) {
    $output = new \Mikron\HubBack\Domain\Service\Output(
        "Front page",
        "This is basic front page. Please choose a functionality you wish to access from 'content' area",
        [
            [
                "url" => "characters/{authentication-method}/{authentication-key}/",
                "description" => "Lists all characters available in the system"
            ],
            [
                "url" => "character/{identification-method}/{identification-key}/{authentication-method}/{authentication-key}/",
                "description" => "Specific character data"
            ],
            [
                "url" => "person/{identification-method}/{identification-key}/{authentication-method}/{authentication-key}/",
                "description" => "Specific person data"
            ],
        ]
    );

    return $app->json($output->getArrayForJson());
});
