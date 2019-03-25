<?php

namespace App\Projectors;

use App\Events\StackCreated;
use App\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class StacksProjector implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        StackCreated::class,
    ];

    public function onStackCreated(StackCreated $event)
    {
        User::findByUuid($event->user_uuid)->stacks()->create([
            'uuid' => $event->stack_uuid,
            'name' => $event->name,
            'order' => $event->order,
        ]);
    }
}
