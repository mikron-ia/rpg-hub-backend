<?php

/* Reputation data of a particular person */
$app->get(
    '/character/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $dbEngine = $app['config']['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
        $connection = new $dbClass($app['config'][$dbEngine]);

        $factory = new \Mikron\HubBack\Infrastructure\Factory\Character();

        $character = $factory->retrieveCharacterFromDb(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            $identificationKey
        );

        $output = new \Mikron\HubBack\Domain\Service\Output(
            "Character data",
            "Characters complete details",
            $character->getCompleteData()
        );

        return $app->json($output->getArrayForJson());
    }
);
