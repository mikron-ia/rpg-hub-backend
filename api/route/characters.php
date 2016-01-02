<?php

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\DisplayableLoader;

/* List of all characters available for display */
$app->get(
    '/characters/{authenticationMethod}/{authenticationKey}/',
    function ($authenticationMethod, $authenticationKey) use ($app) {
        DisplayableLoader::checkAuthentication($app['config'], $authenticationMethod, $authenticationKey);
        $connection = DisplayableLoader::provideConnection($app['config']);
        $factory = new \Mikron\HubBack\Infrastructure\Factory\Character();

        /**
         * @var Displayable $characterObjects [] Characters list
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
