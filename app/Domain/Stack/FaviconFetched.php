<?php

namespace App\Domain\Stack;

use App\Support\DomainEvent;

class FaviconFetched extends DomainEvent
{
    /** @var string */
    public $host;

    /** @var string */
    public $filename;
}
