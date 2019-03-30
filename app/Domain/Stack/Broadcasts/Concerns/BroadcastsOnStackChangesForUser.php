<?php

namespace App\Domain\Stack\Broadcasts\Concerns;

use Illuminate\Broadcasting\PrivateChannel;

trait BroadcastsOnStackChangesForUser
{
    /** @var string */
    protected $userUuid;

    public function broadcastOn()
    {
        return new PrivateChannel("stack_changes_for_user_{$this->userUuid}");
    }
}
