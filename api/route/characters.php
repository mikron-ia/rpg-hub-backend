<?php

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Service\Output;

/* List of all characters available for display */
$app->get(
    '/characters/{authenticationMethod}/{authenticationKey}/',
    function ($authenticationMethod, $authenticationKey) use ($app) {

        $authentication = new \Mikron\HubBack\Infrastructure\Security\Authentication(
            $app['config']['authentication'],
            'front',
            $authenticationMethod
        );

        /* Check credentials */
        if (!$authentication->isAuthenticated($authenticationKey)) {
            throw new \Mikron\HubBack\Domain\Exception\AuthenticationException(
                "Authentication code does not check out",
                "Authentication code $authenticationKey for method $authenticationMethod does not check out"
            );
        }

        $dbEngine = $app['config']['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
        $connection = new $dbClass($app['config'][$dbEngine]);

        $factory = new \Mikron\HubBack\Infrastructure\Factory\Character();

        /**
         * @var Displayable $characterObjects[] Characters list
         */
        $characterObjects = $factory->retrieveAllFromDb(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            null
        );
        $characterList = [];

        foreach ($characterObjects as $character) {
            $characterList[] = $character->getSimpleData();
        }

        $output = new Output(
            "List of characters",
            "This is a complete list of character available for your peruse." .
            "If the character you are looking for is not here, please ensure you have correct access rights.",
            $characterList
        );

        return $app->json($output->getArrayForJson());

    }
);
