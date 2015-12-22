<?php

/* Reputation data of a particular person */
$app->get(
    '/person/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $dbEngine = $app['config']['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
        $connection = new $dbClass($app['config'][$dbEngine]);

        $personFactory = new \Mikron\HubBack\Infrastructure\Factory\Person();

        /* Verify whether identification method makes sense */
        $method = "retrievePersonFromDbBy" . ucfirst($identificationMethod);
        if (!method_exists($personFactory, $method)) {
            throw new \Exception(
                'Error: "' . $identificationMethod . '" is not a valid way for object identification'
            );
        }

        /* Prepare data and start the factory */
        $person = $personFactory->$method(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            $identificationKey
        );

        $output = new \Mikron\HubBack\Domain\Service\Output(
            "Person data",
            "Complete personal data",
            $person->getCompleteData()
        );

        return $app->json($output->getArrayForJson());
    }
);
