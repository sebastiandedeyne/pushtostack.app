<?php

namespace App\Domain\Stack\Broadcasts;

use App\Domain\Stack\Models\Stack;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StackCreated implements ShouldBroadcast
{
    /** @var \App\Domain\Stack\Models\Stack */
    private $stack;

    public function __construct(Stack $stack)
    {
        $this->stack = $stack;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stacks.{$this->stack->uuid}");
    }

    public function broadcastWith()
    {
        return $this->stack->toArray();
    }

    public function broadcastAs()
    {
        return 'stack_created';
    }
}
