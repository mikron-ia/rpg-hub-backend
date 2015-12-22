<?php

namespace Mikron\HubBack\Domain\Exception;

/**
 * Class ExceptionWithSafeMessage
 * Contains message safe for display in a non-debug environment
 *
 * @package Mikron\HubBack\Domain\Exception
 */
class ExceptionWithSafeMessage extends \Exception
{
    protected $safeMessage;

    public function __construct($safeMessage = "", $message = "", $code = 0, \Exception $previous = null)
    {
        $this->safeMessage = $safeMessage;

        /* Fallback in case only one message is provided */
        if(empty($message)) {
            $message = $safeMessage;
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getSafeMessage()
    {
        return $this->safeMessage;
    }
}
