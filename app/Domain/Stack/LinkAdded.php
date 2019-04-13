<?php

namespace App\Domain\Stack;

use App\Support\DomainEvent;

class LinkAdded extends DomainEvent
{
    /** @var string */
    public $link_uuid;

    /** @var string */
    public $stack_uuid;

    /** @var string */
    public $user_uuid;

    /** @var string */
    public $url;

    /** @var string|null */
    public $title;

    /** @var string[] */
    public $tags;

    /** @var string */
    public $added_at;
}
