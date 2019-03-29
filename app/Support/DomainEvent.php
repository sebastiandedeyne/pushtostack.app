<?php

namespace App\Support;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

abstract class DomainEvent extends DataTransferObject implements ShouldBeStored
{
}
