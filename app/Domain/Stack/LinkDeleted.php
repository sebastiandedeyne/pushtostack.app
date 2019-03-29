<?php

namespace App\Domain\Stack;

use App\Support\DomainEvent;

class LinkDeleted extends DomainEvent
{
    /** @var string */
    public $link_uuid;
}
