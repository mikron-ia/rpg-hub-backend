<?php

namespace Mikron\HubBack\Domain\Value;

/**
 * Class Text - class for potentially multi-language text
 * @package Mikron\HubBack\Domain\Value
 */
class Text
{
    /**
     * @var \string[]
     */
    private $texts;

    /**
     * @var string
     */
    private $defaultLanguage;

    /**
     * Text constructor.
     * @param \string[] $texts
     * @param \string $defaultLanguage
     */
    public function __construct(array $texts, $defaultLanguage)
    {
        $this->texts = $texts;
        $this->defaultLanguage = $defaultLanguage;
    }

    public function getText($language)
    {
        if(isset($this->texts[$language])) {
            return $this->texts[$language];
        } else {
            return $this->texts[$this->defaultLanguage];
        }
    }
}
