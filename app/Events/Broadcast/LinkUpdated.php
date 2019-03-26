<?php

namespace App\Events\Broadcast;

use App\Link;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LinkUpdated implements ShouldBroadcast
{
    /** @var \App\Link */
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
