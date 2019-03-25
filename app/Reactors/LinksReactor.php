<?php

namespace App\Reactors;

use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;
use App\Events\LinkAdded;
use App\Events\TitleFetched;

class LinksReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        LinkAdded::class,
    ];

    public function onLinkAdded(LinkAdded $event)
    {
        if ($event->title) {
            return;
        }

        event(new TitleFetched([
            'link_uuid' => $event->link_uuid,
            'title' => 'Websites & webapplications in Laravel | Spatie',
        ]));
    }
}
