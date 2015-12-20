<?php

/* Reputation data of a particular person */
$app->get('/character/{id}/', function ($id) use ($app) {
    $dbEngine = $app['config']['dbEngine'];
    $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
        . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
    $connection = new $dbClass($app['config'][$dbEngine]);

    $factory = new \Mikron\HubBack\Infrastructure\Factory\Character();

    $character = $factory->retrieveCharacterFromDb($connection, $app['config']['dataPatterns'], $id);

    $output = new \Mikron\HubBack\Domain\Service\Output(
        "Character data",
        "",
        [$character->getName()]
    );

    return $app->json($output->getArrayForJson());
});
