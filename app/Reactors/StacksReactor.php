<?php

namespace App\Reactors;

use App\Events\Broadcast\BroadcastLinkUpdated;
use App\Events\Broadcast\BroadcastStackUpdated;
use App\Events\FaviconFetched;
use App\Events\LinkAdded;
use App\Events\TitleFetched;
use App\Jobs\FetchFavicon;
use App\Jobs\FetchTitle;
use App\Projections\Link;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;
use Spatie\Url\Url;

class StacksReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        LinkAdded::class,
        TitleFetched::class,
        FaviconFetched::class,
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

        event(new BroadcastStackUpdated($link->stack));
    }

    public function onTitleFetched(TitleFetched $event)
    {
        event(new BroadcastLinkUpdated(Link::findByUuid($event->link_uuid)));
    }

    public function onFaviconFetched(FaviconFetched $event)
    {
        Link::where('host', $event->host)->each(function (Link $link) {
            event(new BroadcastLinkUpdated($link));
        });
    }
}
