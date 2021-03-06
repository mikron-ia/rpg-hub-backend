<?php

namespace Mikron\HubBack\Domain\Value;

/**
 * Class Description - contains text of the description
 * @package Mikron\HubBack\Domain\Value
 */
class Description
{
    /**
     * @var string Title of the description
     */
    private $title;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string Description text visible to everyone
     */
    private $publicText;

    /**
     * @var string GM notes
     */
    private $notes;

    /**
     * Description constructor.
     * @param string $title
     * @param string $code
     * @param string $publicText
     * @param string $notes
     */
    public function __construct($title, $code, $publicText, $notes)
    {
        $this->title = $title;
        $this->code = $code;
        $this->publicText = $publicText;
        $this->notes = $notes;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPublicText()
    {
        return $this->publicText;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
