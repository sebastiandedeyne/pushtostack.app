<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;
use Spatie\DataTransferObject\DataTransferObject;

class LinkAdded extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $uuid;

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
