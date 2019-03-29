<?php

namespace App\Domain\Stack\Projectors;

use App\Domain\Stack\FaviconFetched;
use App\Domain\Stack\LinkAdded;
use App\Domain\Stack\LinkDeleted;
use App\Domain\Stack\Models\Link;
use App\Domain\Stack\Models\Stack;
use App\Domain\Stack\StackCreated;
use App\Domain\Stack\TitleFetched;
use Spatie\EventProjector\Models\StoredEvent;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;
use Spatie\Url\Url;
use App\Domain\User\UserRegistered;

class StacksProjector implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        UserRegistered::class,
        StackCreated::class,
        LinkAdded::class,
        LinkDeleted::class,
        TitleFetched::class,
        FaviconFetched::class,
    ];

    public function onUserRegistered(UserRegistered $event): void
    {
        Stack::create([
            'uuid' => $event->inbox_uuid,
            'name' => 'Inbox',
            'order' => 1,
            'user_uuid' => $event->user_uuid,
        ]);
    }

    public function onStackCreated(StackCreated $event): void
    {
        Stack::create([
            'uuid' => $event->stack_uuid,
            'name' => $event->name,
            'order' => $event->order,
            'parent_uuid' => $event->parent_uuid,
            'user_uuid' => $event->user_uuid,
        ]);
    }

    public function onLinkAdded(LinkAdded $event): void
    {
        $stack = Stack::findByUuid($event->stack_uuid);

        $host = Url::fromString($event->url)->getHost();

        $faviconUrl = Link::where('host', $host)
            ->take(1)
            ->pluck('favicon_url')
            ->first();

        $title = $event->title;

        if (!$title) {
            $title = Link::where('url', $event->url)
                ->take(1)
                ->pluck('title')
                ->first();
        }

        Link::create([
            'uuid' => $event->link_uuid,
            'url' => $event->url,
            'host' => $host,
            'title' => $title ?: $event->url,
            'stack_id' => $stack->id,
            'stack_uuid' => $stack->uuid,
            'user_uuid' => $stack->user_uuid,
            'favicon_url' => $faviconUrl,
            'added_at' => $event->added_at,
        ]);

        $stack->increment('link_count');

        $stack->save();
    }

    public function onLinkDeleted(LinkDeleted $event, StoredEvent $storedEvent): void
    {
        $link = Link::findByUuid($event->link_uuid);

        $link->delete();

        $link->stack->decrement('link_count');

        // We need to keep track of the stack_uuid to broadcast events to the
        // right channel in the BroadcastReactor.
        $storedEvent->meta_data['stack_uuid'] = $link->stack_uuid;
        $storedEvent->save();
    }

    public function onTitleFetched(TitleFetched $event): void
    {
        Link::findByUuid($event->link_uuid)
            ->update(['title' => $event->title]);
    }

    public function onFaviconFetched(FaviconFetched $event): void
    {
        Link::where('host', $event->host)
            ->each(function (Link $link) use ($event) {
                $link->update(['favicon_url' => url("storage/favicons/{$event->filename}")]);
            });
    }

    public function hasReceivedAllPriorEvents(StoredEvent $storedEvent): bool
    {
        return true;
    }

    public function hasReceivedAllEvents(): bool
    {
        return true;
    }
}
