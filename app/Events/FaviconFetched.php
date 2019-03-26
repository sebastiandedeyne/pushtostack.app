<?php

namespace App\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class FaviconFetched extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $link_uuid;

    /** @var string */
    public $url;
}
