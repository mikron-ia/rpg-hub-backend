<?php

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\Loader;

/* List of all people available for display */
$app->get(
    '/people/{authenticationMethod}/{authenticationKey}/',
    function ($authenticationMethod, $authenticationKey) use ($app) {
        Loader::checkAuthentication($app['config'], $authenticationMethod, $authenticationKey);
        $connection = Loader::provideConnection($app['config']);
        $factory = new \Mikron\HubBack\Infrastructure\Factory\Person();

        /**
         * @var Displayable[] $peopleObjects Characters list
         */
        $peopleObjects = $factory->retrieveAllVisibleFromDb(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            null
        );
        $peopleList = [];

        foreach ($peopleObjects as $person) {
            $peopleList[] = $person->getSimpleData();
        }

        $output = new Output(
            "List of people",
            "This is a complete list of people available for your peruse." .
            "If the person you are looking for is not here, please ensure you have correct access rights.",
            $peopleList
        );

        return $app->json($output->getArrayForJson());

    }
);
