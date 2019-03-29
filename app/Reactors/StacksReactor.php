<?php

namespace App\Reactors;

use App\Events\LinkAdded;
use App\Jobs\FetchFavicon;
use App\Jobs\FetchTitle;
use App\Projections\Link;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

class StacksReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        LinkAdded::class,
    ];

    public function onLinkAdded(LinkAdded $event)
    {
        if (!$event->title) {
            dispatch(new FetchTitle($event->url, $event->link_uuid));
        }

        $link = Link::findByUuid($event->link_uuid);

        if (!$link->favicon_url) {
            dispatch(new FetchFavicon($event->url));
        }
    }
}
