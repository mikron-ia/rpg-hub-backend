<?php

namespace Mikron\HubBack\Domain\Exception;

/**
 * Class ExceptionWithSafeMessage
 *
 * @package Mikron\HubBack\Domain\Exception
 */
class ExceptionWithSafeMessage extends \Exception
{
    /**
     * @var string Message safe to display in a non-debug environment
     */
    protected $safeMessage;

    public function __construct($safeMessage = "", $message = "", $code = 0, \Exception $previous = null)
    {
        $this->safeMessage = $safeMessage;

        /* Fallback in case only one message is provided */
        if (empty($message)) {
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
