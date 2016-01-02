<?php

namespace Mikron\HubBack\Infrastructure\Connection;

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Exception\AuthenticationException;
use Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage;
use Mikron\HubBack\Infrastructure\Security\Authentication;

/**
 * Class DisplayableLoader
 * @package Mikron\HubBack\Infrastructure\Connection
 */
class DisplayableLoader
{
    public static function load($app, $class, $identificationMethod, $identificationKey, $authenticationMethod, $authenticationKey)
    {
        $authentication = new Authentication(
            $app['config']['authentication'],
            'front',
            $authenticationMethod
        );

        /* Check credentials */
        if (!$authentication->isAuthenticated($authenticationKey)) {
            throw new AuthenticationException(
                "Authentication code does not check out",
                "Authentication code $authenticationKey for method $authenticationMethod does not check out"
            );
        }

        $dbEngine = $app['config']['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $app['config']['databaseReference'][$dbEngine] . 'StorageEngine';
        $connection = new $dbClass($app['config'][$dbEngine]);

        $className = '\Mikron\HubBack\Infrastructure\Factory\\'.$class;

        $factory = new $className();

        /* Verify whether identification method makes sense */
        $method = "retrieve" . ucfirst($class) . "FromDbBy" . ucfirst($identificationMethod);
        if (!method_exists($factory, $method)) {
            throw new ExceptionWithSafeMessage(
                'Error: "' . $identificationMethod . '" is not a valid way for object identification'
            );
        }

        /**
         * @var Displayable $object
         */
        $object = $factory->$method(
            $connection,
            $app['config']['dataPatterns'],
            $app['config']['help'],
            $identificationKey
        );

        return $object;
    }
}