<?php

namespace App\Projectors;

use App\Events\LinkAdded;
use App\Link;
use App\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;
use App\Stack;
use App\Events\TitleFetched;

class LinksProjector implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        LinkAdded::class,
        TitleFetched::class,
    ];

    public function onLinkAdded(LinkAdded $event, $storedEvent)
    {
        $user = User::findByUuid($event->user_uuid);
        $stack = Stack::findByUuid($event->stack_uuid);

        Link::create([
            'uuid' => $event->link_uuid,
            'url' => $event->url,
            'domain' => explode('/', $event->url)[2],
            'title' => $event->title ?: $event->url,
            'user_id' => $user->id,
            'stack_id' => $stack->id,
            'stack_uuid' => $event->stack_uuid,
            'added_at' => $event->added_at,
        ]);

        $stack->increment('link_count');
    }

    public function onTitleFetched(TitleFetched $event)
    {
        // Link::findByUuid($event->link_uuid)
        //     ->update(['title' => $event->title]);
    }
}
