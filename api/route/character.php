<?php

/* Reputation data of a particular person */
$app->get('/character/{id}', function ($id) use ($app) {
    $dbEngine = $app['config.deploy']['dbEngine'];
    $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
        . $app['config.main']['databaseReference'][$dbEngine] . 'StorageEngine';
    $connection = new $dbClass($app['config.deploy'][$dbEngine]);

    $factory = new \Mikron\HubBack\Infrastructure\Factory\Character();

    $person = $factory->retrieveCharacterFromDb($connection,$id);

    $output = new \Mikron\HubBack\Domain\Service\Output(
        "Character data",
        "",
        [$person->getName()]
    );

    return $app->json($output->getArrayForJson());
});
