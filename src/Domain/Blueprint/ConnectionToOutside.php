<?php

namespace Mikron\HubBack\Domain\Blueprint;

/**
 * Interface ConnectionToOutside - represents HTTP connector to outside world
 * @package Mikron\HubBack\Domain\Blueprint
 */
interface ConnectionToOutside
{
    /**
     * @param string[] $additionalUri Data to pass via URI, like {string0}/{string1}
     * @return string Content of the data
     */
    public function retrieve($additionalUri);
}
