<?php

namespace Mikron\HubBack\Domain\Value;
use Mikron\HubBack\Domain\Exception\IncorrectConfigurationComponentException;

/**
 * Class Code - identification code
 * @package Mikron\HubBack\Domain\Value
 */
class Code
{
    /**
     * @var string
     */
    private $code;

    /**
     * Code constructor.
     * @param string $code
     */
    public function __construct($code)
    {
        if ($this->validate($code)) {
            $this->code = $code;
        }
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $code
     * @return bool
     * @throws IncorrectConfigurationComponentException
     */
    public function validate($code)
    {
        if (empty($code)) {
            throw new IncorrectConfigurationComponentException("Code is empty");
        }

        return true;
    }
}
