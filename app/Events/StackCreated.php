<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;
use Spatie\DataTransferObject\DataTransferObject;

class StackCreated extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $uuid;

    /** @var string */
    public $user_uuid;

    /** @var string */
    public $name;

    /** @var int */
    public $order;
}
