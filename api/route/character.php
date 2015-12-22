<?php

/* Reputation data of a particular person */
use Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage;

$app->get(
    '/character/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {
        $dbEngine = $app['config']['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
        $connection = new $dbClass($app['config'][$dbEngine]);

        $characterFactory = new \Mikron\HubBack\Infrastructure\Factory\Character();

        /* Verify whether identification method makes sense */
        $method = "retrieveCharacterFromDbBy" . ucfirst($identificationMethod);
        if (!method_exists($characterFactory, $method)) {
            throw new ExceptionWithSafeMessage(
                'Error: "' . $identificationMethod . '" is not a valid way for object identification'
            );
        }

        /* Prepare data and start the factory */
        $character = $characterFactory->$method(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            $identificationKey
        );

        $output = new \Mikron\HubBack\Domain\Service\Output(
            "Character data",
            "Characters complete details",
            $character->getCompleteData()
        );

        return $app->json($output->getArrayForJson());
    }
);
