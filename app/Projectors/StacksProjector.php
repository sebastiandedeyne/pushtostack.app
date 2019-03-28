<?php

namespace App\Projectors;

use App\Events\Broadcast\BroadcastLinkUpdated;
use App\Events\Broadcast\BroadcastStackUpdated;
use App\Events\BroadcastLinkDeleted;
use App\Events\FaviconFetched;
use App\Events\LinkAdded;
use App\Events\LinkDeleted;
use App\Events\StackCreated;
use App\Events\TitleFetched;
use App\Projections\Link;
use App\Projections\Stack;
use App\Projections\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;
use Spatie\Url\Url;

class StacksProjector implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        StackCreated::class,
        LinkAdded::class,
        LinkDeleted::class,
        TitleFetched::class,
        FaviconFetched::class,
    ];

    public function onStackCreated(StackCreated $event): void
    {
        User::findByUuid($event->user_uuid)->stacks()->create([
            'uuid' => $event->stack_uuid,
            'name' => $event->name,
            'order' => $event->order,
        ]);
    }

    public function onLinkAdded(LinkAdded $event): void
    {
        $user = User::findByUuid($event->user_uuid);
        $stack = Stack::findByUuid($event->stack_uuid);

        $host = Url::fromString($event->url)->getHost();

        $faviconUrl = Link::where('host', $host)
            ->take(1)
            ->pluck('favicon_url')
            ->first();

        Link::create([
            'uuid' => $event->link_uuid,
            'url' => $event->url,
            'host' => $host,
            'title' => $event->title ?: $event->url,
            'user_id' => $user->id,
            'stack_id' => $stack->id,
            'stack_uuid' => $event->stack_uuid,
            'favicon_url' => $faviconUrl,
            'added_at' => $event->added_at,
        ]);

        $stack->increment('link_count');
    }

    public function onLinkDeleted(LinkDeleted $event): void
    {
        $link = Link::findByUuid($event->link_uuid);

        $link->delete();

        $link->stack->decrement('link_count');
    }

    public function onTitleFetched(TitleFetched $event): void
    {
        $link = Link::findByUuid($event->link_uuid);

        $link->update(['title' => $event->title]);

        event(new BroadcastLinkUpdated($link));
    }

    public function onFaviconFetched(FaviconFetched $event): void
    {
        Link::where('host', $event->host)
            ->each(function (Link $link) use ($event) {
                $link->update(['favicon_url' => url("storage/favicons/{$event->filename}")]);

                event(new BroadcastLinkUpdated($link));
            });
    }

    public function mustReceiveAllPriorEventsBeforeProjecting(): bool
    {
        return false;
    }
}
