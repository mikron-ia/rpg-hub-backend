<?php

namespace Mikron\HubBack\Infrastructure\Security;

use Mikron\HubBack\Domain\Blueprint\AuthenticationToken;
use Mikron\HubBack\Domain\Exception\AuthenticationException;

/**
 * Class AuthenticationTokenSimple - simple key-based authentication
 * @package Mikron\HubBack\Infrastructure\Security
 */
final class AuthenticationTokenSimple implements AuthenticationToken
{
    /**
     * @var string Key stored in configuration
     */
    private $correctKey;

    public function __construct($configAuthenticationSettingsForMethod)
    {
        if (!isset($configAuthenticationSettingsForMethod['simple'])) {
            throw new AuthenticationException(
                "Authentication configuration incorrect",
                "No configuration for simple authentication set"
            );
        }

        if (!isset($configAuthenticationSettingsForMethod['simple']['authenticationKey'])) {
            throw new AuthenticationException(
                "Authentication configuration incorrect",
                "No authentication key for simple authentication set"
            );
        }

        if (self::isValid($configAuthenticationSettingsForMethod['simple']['authenticationKey'], 'internal')) {
            $this->correctKey = $configAuthenticationSettingsForMethod['simple']['authenticationKey'];
        }
    }

    static public function isValid($key, $identificationForErrors)
    {
        if (empty($key)) {
            throw new AuthenticationException(
                "Authentication key incorrect",
                "Authentication key incorrect: " . ucfirst($identificationForErrors) . " key must not be empty"
            );
        }

        if (strlen($key) < 20) {
            throw new AuthenticationException(
                "Authentication key incorrect",
                "Authentication key incorrect: " . ucfirst($identificationForErrors) . " key is too short to be used"
            );
        }

        return true;
    }

    public function checksOut($key)
    {
        if (!self::isValid($key, 'received')) {
            return null;
        }

        return $key == $this->correctKey;
    }

    public function provideKey()
    {
        return $this->correctKey;
    }

    public function provideMethod()
    {
        return 'simple';
    }
}
