<?php

namespace App\Domain\Stack\Broadcasts;

use App\Domain\Stack\Models\Link;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LinkUpdated implements ShouldBroadcast
{
    /** @var \App\Domain\Stack\Models\Link */
    private $link;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stacks.{$this->link->stack_uuid}");
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
