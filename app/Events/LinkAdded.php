<?php

namespace App\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class LinkAdded extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $link_uuid;

    /** @var string */
    public $user_uuid;

    /** @var string */
    public $stack_uuid;

    /** @var string */
    public $url;

    /** @var string|null */
    public $title;

    /** @var string */
    public $added_at;
}
