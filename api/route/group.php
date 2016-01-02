<?php

use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\Loader;

/* Data of a particular group */
$app->get(
    '/group/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $group = Loader::loadSingleObject(
            $app['config'],
            'Group',
            $identificationMethod,
            $identificationKey,
            $authenticationMethod,
            $authenticationKey
        );

        $output = new Output(
            "Group data",
            "Complete group data",
            $group->getCompleteData()
        );

        return $app->json($output->getArrayForJson());

    }
);
