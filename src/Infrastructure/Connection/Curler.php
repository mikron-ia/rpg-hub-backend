<?php

namespace Mikron\HubBack\Infrastructure\Connection;

use Mikron\HubBack\Domain\Exception\CurlException;

/**
 * Class Curler - manages cURL usage
 * @package Mikron\HubBack\Infrastructure\Connection
 * @todo Consider using Guzzle for that
 */
class Curler
{
    private $uri;
    private $parameters;

    /**
     * Curler constructor.
     * @param $uri
     * @param $parameters
     */
    public function __construct($uri, $parameters = [])
    {
        $this->uri = $uri;
        $this->parameters = $parameters;
    }

    /**
     * @return string Data from the source
     * @throws CurlException
     */
    public function retrieve()
    {
        $curl = curl_init($this->uri);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);

        curl_setopt_array($curl, $this->parameters);

        $result = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if (!empty($error)) {
            throw new CurlException($error);
        }

        return $result;
    }
}
