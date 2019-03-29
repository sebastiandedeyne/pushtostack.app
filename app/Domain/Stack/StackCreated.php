<?php

namespace App\Domain\Stack;

use App\Support\DomainEvent;

class StackCreated extends DomainEvent
{
    /** @var string */
    public $stack_uuid;

    /** @var string */
    public $user_uuid;

    /** @var string */
    public $name;

    /** @var int */
    public $order;
}
