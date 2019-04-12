<?php

namespace App\Support;

use Exception;
use Spatie\EventProjector\EventSerializers\EventSerializer;
use Spatie\EventProjector\ShouldBeStored;

final class DTOEventSerializer implements EventSerializer
{
    public function serialize(ShouldBeStored $event): string
    {
        if (!method_exists($event, 'toArray')) {
            throw new Exception('Can only serialize DTO events.');
        }

        return json_encode($event->toArray(), true);
    }

    public function deserialize(string $eventClass, string $json): ShouldBeStored
    {
        return new $eventClass(json_decode($json, true));
    }
}
