<?php

namespace Mikron\HubBack\Domain\Blueprint;

/**
 * Interface AuthenticationToken
 * @package Mikron\HubBack\Domain\Blueprint
 */
interface AuthenticationToken
{
    /**
     * AuthenticationToken constructor - accepts key data
     *
     * @param array $configForMethod
     */
    public function __construct($configForMethod);

    /**
     * Verifies if the token is valid
     * @param string $key
     * @return boolean true is token checks out
     */
    public function checksOut($key);

    /**
     * Provides a key to be sent as authentication
     * @return string Provided key
     */
    public function provide();
}
