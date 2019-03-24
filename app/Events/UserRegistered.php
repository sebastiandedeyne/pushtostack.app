<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;
use Spatie\DataTransferObject\DataTransferObject;

class UserRegistered extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $uuid;

    /** @var string */
    public $name;

    /** @var string */
    public $email;

    /** @var string */
    public $password;
}
