<?php

/* Reputation data of a particular person */
$app->get('/character/{id}/', function ($id) use ($app) {
    $dbEngine = $app['config']['dbEngine'];
    $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
        . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
    $connection = new $dbClass($app['config'][$dbEngine]);

    $factory = new \Mikron\HubBack\Infrastructure\Factory\Character();

    $person = $factory->retrieveCharacterFromDb($connection,$id);

    $output = new \Mikron\HubBack\Domain\Service\Output(
        "Character data",
        "",
        [$person->getName()]
    );

    return $app->json($output->getArrayForJson());
});
