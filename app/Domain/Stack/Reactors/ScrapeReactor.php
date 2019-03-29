<?php

namespace App\Domain\Stack\Reactors;

use App\Domain\Stack\LinkAdded;
use App\Domain\Stack\Jobs\FetchFavicon;
use App\Domain\Stack\Jobs\FetchTitle;
use App\Domain\Stack\Models\Link;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

class ScrapeReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        LinkAdded::class,
    ];

    public function onLinkAdded(LinkAdded $event)
    {
        $link = Link::findByUuid($event->link_uuid);

        if (empty($link->title) || $link->title === $link->url) {
            dispatch(new FetchTitle($event->url, $event->link_uuid));
        }

        if (!$link->favicon_url) {
            dispatch(new FetchFavicon($event->url));
        }
    }
}
