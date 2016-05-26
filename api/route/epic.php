<?php

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\Loader;

/* Reputation data of a particular epic */
$app->get(
    '/epic/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        Loader::checkAuthentication($app['config'], $authenticationMethod, $authenticationKey);
        $connection = Loader::provideConnection($app['config']);

        /**
         * Note: $identificationMethod and $identificationKey are for compatibility. This backend is capable of
         * providing data for one epic only, thus are the parameters ignored.
         */
        $epicFactory = new \Mikron\HubBack\Infrastructure\Factory\Epic();

        /**
         * @var Displayable $epic Epic data
         */
        $epic = $epicFactory->retrieveEpic(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            $app['config']['epicData']
        );

        $output = new Output(
            "Epic data",
            "Epic data for epic page and story list",
            $epic->getCompleteData()
        );

        return $app->json($output->getArrayForJson());
    }
);

/* Data of a particular story */
$app->get(
    '/story/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $story = Loader::loadSingleObject(
            $app['config'],
            'Story',
            $identificationMethod,
            $identificationKey,
            $authenticationMethod,
            $authenticationKey
        );

        $output = new Output(
            "Story data",
            "Complete story data",
            $story->getCompleteData()
        );

        return $app->json($output->getArrayForJson());

    }
);
