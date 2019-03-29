<?php

namespace App\Domain\Stack\Reactors;

use App\Domain\Stack\LinkAdded;
use App\Domain\Stack\Broadcasts;
use App\Domain\Stack\FaviconFetched;
use App\Domain\Stack\LinkDeleted;
use App\Domain\Stack\Models\Link;
use App\Domain\Stack\Models\Stack;
use App\Domain\Stack\TitleFetched;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;
use Spatie\EventProjector\Models\StoredEvent;

class BroadcastReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        LinkAdded::class,
        LinkDeleted::class,
        FaviconFetched::class,
        TitleFetched::class,
    ];

    public function onLinkAdded(LinkAdded $event)
    {
        event(new Broadcasts\LinkCreated(Link::findByUuid($event->link_uuid)));

        event(new Broadcasts\StackUpdated(Stack::findByUuid($event->stack_uuid)));
    }

    public function onLinkDeleted(LinkDeleted $event, StoredEvent $storedEvent)
    {
        event(new Broadcasts\LinkDeleted(
            $event->link_uuid,
            $storedEvent->meta_data['stack_uuid']
        ));

        event(new Broadcasts\StackUpdated(
            Stack::findByUuid($storedEvent->meta_data['stack_uuid'])
        ));
    }

    public function onFaviconFetched(FaviconFetched $event)
    {
        Link::where('host', $event->host)->each(function (Link $link) {
            event(new Broadcasts\LinkUpdated($link));
        });
    }

    public function onTitleFetched(TitleFetched $event)
    {
        event(new Broadcasts\LinkUpdated(Link::findByUuid($event->link_uuid)));
    }
}
