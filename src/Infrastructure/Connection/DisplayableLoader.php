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
    public static function checkAuthentication($config, $authenticationMethod, $authenticationKey)
    {
        $authentication = new Authentication(
            $config['authentication'],
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
    }

    public static function provideConnection($config)
    {
        $dbEngine = $config['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $config['databaseReference'][$dbEngine] . 'StorageEngine';
        return new $dbClass($config[$dbEngine]);
    }

    public static function provideObject($connection, $config, $class, $identificationMethod, $identificationKey)
    {
        $className = '\Mikron\HubBack\Infrastructure\Factory\\' . $class;

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
            $config['dataPatterns'],
            $config['help'],
            $identificationKey
        );

        return $object;
    }

    public static function loadSingleObject(
        $config, $class,
        $identificationMethod, $identificationKey,
        $authenticationMethod, $authenticationKey
    )
    {
        self::checkAuthentication($config, $authenticationMethod, $authenticationKey);
        $connection = self::provideConnection($config);
        return self::provideObject($connection, $config, $class, $identificationMethod, $identificationKey);
    }
}
