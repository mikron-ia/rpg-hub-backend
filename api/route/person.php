<?php

use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\DisplayableLoader;

/* Reputation data of a particular person */
$app->get(
    '/person/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $person = DisplayableLoader::load(
            $app['config'],
            'Person',
            $identificationMethod,
            $identificationKey,
            $authenticationMethod,
            $authenticationKey
        );

        $output = new Output(
            "Person data",
            "Complete personal data",
            $person->getCompleteData()
        );

        return $app->json($output->getArrayForJson());
    }
);
