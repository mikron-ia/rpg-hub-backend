<?php

namespace Mikron\HubBack\Domain\Service;

use Mikron\HubBack\Domain\Blueprint\ConnectionToOutside;
use Mikron\HubBack\Domain\Exception\InvalidDataException;
use Mikron\HubBack\Domain\Exception\InvalidSourceException;
use Mikron\HubBack\Infrastructure\Connection\Curler;

/**
 * Class Retriever - retrieves data from a module
 * @package Mikron\HubBack\Domain\Service
 */
class Retriever
{
    /**
     * @var ConnectionToOutside Data source
     */
    private $connection;

    /**
     * @var string Retrieved data in JSON
     */
    private $json;

    /**
     * @var string Retrieved data in array
     */
    private $data;

    /**
     * @var $address string[] Address for URI in form of uri segments
     */
    private $address;

    /**
     * Retriever constructor.
     * @param ConnectionToOutside $connection
     * @param string[] $address
     * @throws InvalidDataException
     */
    public function __construct($connection, $address)
    {
        $this->connection = $connection;
        $this->address = $address;

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
     */
    private function retrieve()
    {
        $address = implode('/', $this->address);
        return $this->connection->retrieve($address);
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
