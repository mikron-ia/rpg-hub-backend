<?php

namespace Mikron\HubBack\Infrastructure\Connection;

use Mikron\HubBack\Domain\Blueprint\Displayable;
use Mikron\HubBack\Domain\Blueprint\StorageEngine;
use Mikron\HubBack\Domain\Exception\AuthenticationException;
use Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage;
use Mikron\HubBack\Infrastructure\Security\Authentication;

/**
 * Class DisplayableLoader
 * @package Mikron\HubBack\Infrastructure\Connection
 */
class Loader
{
    /**
     * @param array $config
     * @param string $authenticationMethod
     * @param string $authenticationKey
     * @throws AuthenticationException
     */
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

    /**
     * @param array $config
     * @return StorageEngine
     */
    public static function provideConnection($config)
    {
        $dbEngine = $config['dbEngine'];
        $dbClass = '\Mikron\HubBack\Infrastructure\Storage\\'
            . $config['databaseReference'][$dbEngine] . 'StorageEngine';
        return new $dbClass($config[$dbEngine]);
    }

    /**
     * @param StorageEngine $connection
     * @param array $config
     * @param string $class
     * @param string $identificationMethod
     * @param string $identificationKey
     * @return Displayable
     * @throws ExceptionWithSafeMessage
     */
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

        $object = $factory->$method(
            $connection,
            $config['dataPatterns'],
            $config['help'],
            $identificationKey
        );

        return $object;
    }

    /**
     * @param array $config Configuration data
     * @param string $class Name of the class used
     * @param string $identificationMethod Method to find object
     * @param string $identificationKey Key that identifies the object
     * @param string $authenticationMethod Authentication method
     * @param string $authenticationKey Authentication key
     * @return Displayable
     * @throws AuthenticationException
     * @throws ExceptionWithSafeMessage
     */
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
