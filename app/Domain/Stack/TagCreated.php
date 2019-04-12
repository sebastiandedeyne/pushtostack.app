<?php

namespace App\Domain\Stack;

use App\Support\DomainEvent;

class TagCreated extends DomainEvent
{
    /** @var string */
    public $tag_uuid;

    /** @var string */
    public $user_uuid;

    /** @var string */
    public $name;

    /** @var int */
    public $order;
}
