<?php

namespace App\Events\Broadcasts;

use App\Projections\Stack;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StackCreated implements ShouldBroadcast
{
    /** @var \App\Projections\Stack */
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
}
