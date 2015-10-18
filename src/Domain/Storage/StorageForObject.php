<?php

namespace Mikron\HubBack\Domain\Storage;

interface StorageForObject
{
    public function retrieve($dbId);
    public function retrieveAll();
}
