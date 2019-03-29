<?php

namespace App\Domain\Stack;

use App\Support\DomainEvent;

class TitleFetched extends DomainEvent
{
    /** @var string */
    public $link_uuid;

    /** @var string */
    public $title;
}
