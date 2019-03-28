<?php

namespace App\Events\Broadcast;

use App\Projections\Link;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastLinkUpdated implements ShouldBroadcast
{
    /** @var \App\Projections\Link */
    private $link;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stacks.{$this->link->stack->uuid}");
    }

    public function broadcastWith()
    {
        return $this->link->toArray();
    }
}
