<?php

namespace Mikron\HubBack\Domain\Entity;

use Mikron\HubBack\Domain\Value\DescriptionPack;
use Mikron\HubBack\Domain\Value\StorageIdentification;
use Mikron\HubBack\Domain\Value\Tag;

/**
 * Class Person - represents the face of a character or organisation
 * @package Mikron\HubBack\Domain\Entity
 */
final class Person extends ComplexDataObject
{
    const VISIBILITY_NONE = 'none';         // Person is not visible nor accessible at all - NOT IMPLEMENTED
    const VISIBILITY_LINK = 'linked';     // Person is not visible in index, but accessible via link
    const VISIBILITY_FULL = 'complete'; // Person is visible in index and accessible via link

    /**
     * @var string
     */
    private $visibility;

    /**
     * @var string[]
     */
    private $visibilityAllowedValues = [self::VISIBILITY_NONE, self::VISIBILITY_LINK, self::VISIBILITY_FULL];

    /**
     * @param StorageIdentification|null $identification
     * @param string $name
     * @param DataContainer $data
     * @param string[] $help
     * @param DescriptionPack $descriptionPack
     * @param Tag[] $tags
     * @param string $tagLine
     * @param string $visibility
     */
    public function __construct(
        $identification,
        $name,
        $data,
        array $help,
        $descriptionPack,
        array $tags,
        $tagLine,
        $visibility
    ) {
        parent::__construct($identification, $name, $data, $help, $descriptionPack, $tags, $tagLine);

        if (in_array($visibility, $this->visibilityAllowedValues)) {
            $this->visibility = $visibility;
        } else {
            $this->visibility = self::VISIBILITY_NONE;
        }
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
}
