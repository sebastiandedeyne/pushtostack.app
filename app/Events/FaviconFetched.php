<?php

namespace App\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class FaviconFetched extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $host;

    /** @var string */
    public $filename;
}
