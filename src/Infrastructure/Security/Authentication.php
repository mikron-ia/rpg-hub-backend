<?php

namespace Mikron\HubBack\Infrastructure\Security;

use Mikron\HubBack\Domain\Blueprint\AuthenticationToken;
use Mikron\HubBack\Domain\Exception\AuthenticationException;

/**
 * Class AuthenticationFactory
 * @package Mikron\HubBack\Infrastructure\Security
 */
class Authentication
{
    /**
     * @var AuthenticationToken
     */
    private $token;

    /**
     * @param array $config Configuration segment responsible for authentication
     * @param string $direction Who is trying to talk to us and which keyset is used?
     * @param string $authenticationMethodReceived What method are they trying to use?
     * @throws AuthenticationException
     */
    public function __construct($config, $direction, $authenticationMethodReceived)
    {
        if (!isset($config['authenticationMethodReference'])) {
            throw new AuthenticationException(
                "Authentication configuration error",
                "Authentication configuration error: missing reference table for authentication methods"
            );
        }

        if (!isset($config['authenticationMethodReference'][$authenticationMethodReceived])) {
            throw new AuthenticationException(
                "Authentication configuration error",
                "Authentication configuration error: missing reference for '$authenticationMethodReceived' method"
            );
        }

        $authenticationMethod = $config['authenticationMethodReference'][$authenticationMethodReceived];

        if (!in_array($authenticationMethod, $config[$direction]['allowedStrategies'])) {
            throw new AuthenticationException(
                "Authentication strategy '$authenticationMethod' ('$authenticationMethodReceived') not allowed"
            );
        }

        $this->token = $this->createToken($config[$direction], $authenticationMethod);
    }

    /**
     * @param array $configWithChosenDirection
     * @param string $authenticationMethod
     * @return AuthenticationToken
     * @throws AuthenticationException
     */
    private function createToken($configWithChosenDirection, $authenticationMethod)
    {
        $className = 'Mikron\HubBack\Infrastructure\Security\AuthenticationToken' . ucfirst($authenticationMethod);

        if (!class_exists($className)) {
            throw new AuthenticationException(
                "Authentication configuration error",
                "Authentication configuration error: class $className, despite being allowed, does not exist"
            );
        }

        return new $className($configWithChosenDirection['settingsByStrategy']);
    }

    /**
     * @param string $authenticationKey What is the key they present?
     * @return bool
     */
    public function isAuthenticated($authenticationKey)
    {
        return $this->token->checksOut($authenticationKey);
    }

    /**
     * Provides authentication method for use in outgoing message
     * @return string
     */
    public function provideAuthenticationMethod()
    {
        return 'auth-' . $this->token->provideMethod();
    }

    /**
     * Provides authentication key for use in outgoing message
     * @return string
     */
    public function provideAuthenticationKey()
    {
        return $this->token->provideKey();
    }
}
