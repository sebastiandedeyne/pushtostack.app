<?php

namespace App\Domain\Stack\Broadcasts;

use App\Domain\Stack\Broadcasts\Concerns\BroadcastsOnLinkChangesInStack;
use App\Domain\Stack\Models\Link;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LinkCreated implements ShouldBroadcast
{
    use BroadcastsOnLinkChangesInStack;

    /** @var \App\Domain\Stack\Models\Link */
    private $link;

    public function __construct(Link $link)
    {
        $this->link = $link;

        $this->stackUuid = $link->stack_uuid;
    }

    public function broadcastWith()
    {
        return $this->link->toArray();
    }

    public function broadcastAs()
    {
        return 'link_created';
    }
}
