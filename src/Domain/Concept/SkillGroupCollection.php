<?php

namespace Mikron\HubBack\Domain\Concept;

use Mikron\HubBack\Domain\Blueprint\Collection;

class SkillGroupCollection extends Collection
{
    protected function isValid($validatedObject)
    {
        return $validatedObject instanceof SkillGroup;
    }
}
