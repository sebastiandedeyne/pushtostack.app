<?php

namespace App\Support;

use Spatie\EventProjector\EventSerializers\JsonEventSerializer;
use Spatie\EventProjector\ShouldBeStored;

class EventSerializer extends JsonEventSerializer
{
    public function deserialize(string $eventClass, string $json): ShouldBeStored
    {
        return new $eventClass(json_decode($json, true));
    }
}
