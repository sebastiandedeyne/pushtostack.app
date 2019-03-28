<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastLinkDeleted implements ShouldBroadcast
{
    /** @var string */
    private $linkUuid;

    /** @var string */
    private $stackUuid;

    public function __construct(string $linkUuid, string $stackUuid)
    {
        $this->linkUuid = $linkUuid;
        $this->stackUuid = $stackUuid;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stacks.{$this->stackUuid}");
    }

    public function broadcastWith()
    {
        return ['uuid' => $this->linkUuid];
    }
}
