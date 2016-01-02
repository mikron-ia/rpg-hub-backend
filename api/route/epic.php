<?php

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\DisplayableLoader;

/* Reputation data of a particular epic */
$app->get(
    '/epic/{authenticationMethod}/{authenticationKey}/',
    function ($authenticationMethod, $authenticationKey) use ($app) {
        DisplayableLoader::checkAuthentication($app['config'], $authenticationMethod, $authenticationKey);
        $connection = DisplayableLoader::provideConnection($app['config']);
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
        $story = DisplayableLoader::loadSingleObject(
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
