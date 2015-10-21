<?php

/* List of all characters available for display */
$app->get('/characters/', function () use ($app) {
    $dbEngine = $app['config.deploy']['dbEngine'];
    $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
        . $app['config.main']['databaseReference'][$dbEngine] . 'StorageEngine';
    $connection = new $dbClass($app['config.deploy'][$dbEngine]);

    $factory = new \Mikron\HubBack\Infrastructure\Factory\Character();

    $characterObjects = $factory->retrieveAllFromDb($connection);
    $characterList = [];

    foreach ($characterObjects as $character) {
        $characterList[] = $character->getName();
    }

    $output = new \Mikron\HubBack\Domain\Service\Output(
        "List",
        "This is a complete list of character available for your peruse. If the character you are looking for is not"
        ." here, please ensure you have correct access rights.",
        $characterList
    );

    return $app->json($output->getArrayForJson());
});
