<?php

namespace App\Domain\Stack\Broadcasts;

use App\Domain\Stack\Broadcasts\Concerns\BroadcastsOnStackChangesForUser;
use App\Domain\Stack\Models\Stack;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StackUpdated implements ShouldBroadcast
{
    use BroadcastsOnStackChangesForUser;

    /** @var \App\Domain\Stack\Models\Stack */
    private $stack;

    public function __construct(Stack $stack)
    {
        $this->stack = $stack;

        $this->userUuid = $stack->user_uuid;
    }

    public function broadcastWith()
    {
        return $this->stack->refresh()->toArray();
    }

    public function broadcastAs()
    {
        return 'stack_updated';
    }
}
