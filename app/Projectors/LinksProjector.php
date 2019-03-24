<?php

namespace App\Projectors;

use App\Events\LinkAdded;
use App\Link;
use App\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;
use App\Stack;

class LinksProjector implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        LinkAdded::class,
    ];

    public function onLinkAdded(LinkAdded $event, $storedEvent)
    {
        $user = User::findByUuid($event->user_uuid);
        $stack = Stack::findByUuid($event->stack_uuid);

        Link::create([
            'uuid' => $event->uuid,
            'url' => $event->url,
            'title' => $event->title,
            'user_id' => $user->id,
            'stack_id' => $stack->id,
            'added_at' => $event->added_at,
        ]);
    }
}
