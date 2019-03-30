<?php

namespace App\Domain\Stack\Broadcasts;

use App\Domain\Stack\Models\Link;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Domain\Stack\Broadcasts\Concerns\BroadcastsOnLinkChangesInStack;

class LinkUpdated implements ShouldBroadcast
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
        return $this->link->refresh()->toArray();
    }

    public function broadcastAs()
    {
        return 'link_updated';
    }
}
