<?php

namespace Mikron\HubBack\Infrastructure\Factory;

use Mikron\HubBack\Domain\Entity;

/**
 * Class DataContainer
 * @package Mikron\HubBack\Infrastructure\Factory
 */
class DataContainer
{
    /**
     * Creates data container according to provided pattern
     * All records not provided in $data are given default values from the pattern
     *
     * @param array $data Array of data
     * @param array $pattern Array of default values
     * @return Entity\DataContainer
     */
    public function createWithPattern($data, $pattern)
    {
        return new Entity\DataContainer($pattern, $data);
    }

    /**
     * Creates data container without a pattern or any validation
     * CAUTION: this method does not provide default values; should data container be incomplete, errors are likely
     *
     * @param array $data Array of data
     * @return Entity\DataContainer
     */
    public function createWithoutPattern($data)
    {
        return $this->createWithPattern($data, $data);
    }
}
