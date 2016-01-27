<?php

namespace Mikron\HubBack\Domain\Value;

use Mikron\HubBack\Domain\Blueprint\Displayable;

/**
 * Class Tag - contains a simple hashtag
 * @package Mikron\HubBack\Domain\Value
 */
class Tag implements Displayable
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $title;

    /**
     * Tag constructor.
     * @param string $tag
     * @param string $title
     */
    public function __construct($tag, $title)
    {
        $this->tag = $tag;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function getSimpleData()
    {
        return [
            'tag' => $this->getTag(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getCompleteData()
    {
        return [
            'tag' => $this->getTag(),
            'title' => $this->getTitle(),
        ];
    }
}
