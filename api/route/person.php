<?php

/* Reputation data of a particular person */
$app->get('/person/{id}/', function ($id) use ($app) {
    $dbEngine = $app['config']['dbEngine'];
    $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
        . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
    $connection = new $dbClass($app['config'][$dbEngine]);

    $factory = new \Mikron\HubBack\Infrastructure\Factory\Person();

    $person = $factory->retrievePersonFromDb(
        $connection,
        $app['config']['dataPatterns'],
        $app['config']['help'],
        $id
    );

    $output = new \Mikron\HubBack\Domain\Service\Output(
        "Person data",
        "",
        [$person->getCompleteData()]
    );

    return $app->json($output->getArrayForJson());
});
