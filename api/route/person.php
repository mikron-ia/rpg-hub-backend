<?php

/* Reputation data of a particular person */
use Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage;

$app->get(
    '/person/{identificationMethod}/{identificationKey}/{authenticationMethod}/{authenticationKey}/',
    function ($identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey) use ($app) {

        $authentication = new \Mikron\HubBack\Infrastructure\Security\Authentication(
            $app['config']['authentication'],
            'front',
            $authenticationMethod
        );

        /* Check credentials */
        if (!$authentication->isAuthenticated($authenticationKey)) {
            throw new \Mikron\HubBack\Domain\Exception\AuthenticationException(
                "Authentication code does not check out",
                "Authentication code $authenticationKey for method $authenticationMethod does not check out"
            );
        }

        $dbEngine = $app['config']['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
        $connection = new $dbClass($app['config'][$dbEngine]);

        $personFactory = new \Mikron\HubBack\Infrastructure\Factory\Person();

        /* Verify whether identification method makes sense */
        $method = "retrievePersonFromDbBy" . ucfirst($identificationMethod);
        if (!method_exists($personFactory, $method)) {
            throw new ExceptionWithSafeMessage(
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
