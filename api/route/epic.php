<?php

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage;
use Mikron\HubBack\Domain\Service\Output;

/* Reputation data of a particular epic */
$app->get(
    '/epic/{authenticationMethod}/{authenticationKey}/',
    function ($authenticationMethod, $authenticationKey) use ($app) {

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

        $storyFactory = new \Mikron\HubBack\Infrastructure\Factory\Story();

        /* Verify whether identification method makes sense */
        $method = "retrieveStoryFromDbBy" . ucfirst($identificationMethod);
        if (!method_exists($storyFactory, $method)) {
            throw new ExceptionWithSafeMessage(
                'Error: "' . $identificationMethod . '" is not a valid way for object identification'
            );
        }

        /**
         * @var Displayable $story Story data
         */
        $story = $storyFactory->$method(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            $identificationKey
        );

        $output = new Output(
            "Story data",
            "Complete story data",
            $story->getCompleteData()
        );

        return $app->json($output->getArrayForJson());

    }
);
