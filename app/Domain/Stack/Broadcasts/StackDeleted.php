<?php

namespace App\Domain\Stack\Broadcasts;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StackDeleted implements ShouldBroadcast
{
    /** @var string */
    private $stackUuid;

    public function __construct(string $stackUuid)
    {
        $this->stackUuid = $stackUuid;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stacks.{$this->stackUuid}");
    }

    public function broadcastWith()
    {
        return ['uuid' => $this->stackUuid];
    }

    public function broadcastAs()
    {
        return 'stack_deleted';
    }
}
