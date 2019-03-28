<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class LinkDeleted extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $link_uuid;
}
