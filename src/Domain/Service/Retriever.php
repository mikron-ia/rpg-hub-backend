<?php

namespace Mikron\HubBack\Domain\Service;

use Mikron\HubBack\Domain\Exception\InvalidDataException;
use Mikron\HubBack\Domain\Exception\InvalidSourceException;

/**
 * Class Retriever - retrieves data from a module
 * @package Mikron\HubBack\Domain\Service
 */
class Retriever
{
    /**
     * @var string Data source
     */
    private $uri;

    /**
     * @var string Retrieved data in JSON
     */
    private $json;

    /**
     * @var string Retrieved data in array
     */
    private $data;

    /**
     * Retriever constructor.
     * @param $uri
     * @throws InvalidDataException
     * @throws InvalidSourceException
     */
    public function __construct($uri)
    {
        $this->uri = $uri;

        $json = $this->retrieve();
        $this->json = $json;

        $data = json_decode($json, true);
        if (empty($data)) {
            throw new InvalidDataException("Invalid JSON data, unable to decode");
        }
        $this->data = $data;
    }

    /**
     * @return string JSON from the source
     * @throws InvalidSourceException
     */
    private function retrieve()
    {
        $curl = curl_init($this->uri);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);

        $result = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if (!empty($error)) {
            throw new InvalidSourceException("cURL error: " . $error);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getDataAsJSON()
    {
        return $this->json;
    }

    /**
     * @return array
     */
    public function getDataAsArray()
    {
        return $this->data;
    }
}
