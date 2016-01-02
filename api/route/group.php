<?php

use Mikron\HubBack\Domain\Service\Output;
use Mikron\HubBack\Infrastructure\Connection\DisplayableLoader;

/* Data of a particular group */
$app->get(
    '/group/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $group = DisplayableLoader::loadSingleObject(
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
