<?php

namespace App\Domain\Stack\Broadcasts\Concerns;

use Illuminate\Broadcasting\PrivateChannel;

trait BroadcastsOnLinkChangesInStack
{
    /** @var string */
    protected $stackUuid;

    public function broadcastOn()
    {
        return new PrivateChannel("link_changes_in_stack_{$this->stackUuid}");
    }
}
