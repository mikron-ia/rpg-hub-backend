<?php

use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\DisplayableLoader;

/* Reputation data of a particular person */
$app->get(
    '/character/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $character = DisplayableLoader::load(
            $app['config'],
            'Character',
            $identificationMethod,
            $identificationKey,
            $authenticationMethod,
            $authenticationKey
        );

        $output = new Output(
            "Character data",
            "Characters complete details",
            $character->getCompleteData()
        );

        return $app->json($output->getArrayForJson());
    }
);
