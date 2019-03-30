<?php

namespace App\Domain\Stack\Broadcasts;

use App\Domain\Stack\Broadcasts\Concerns\BroadcastsOnStackChangesForUser;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StackDeleted implements ShouldBroadcast
{
    use BroadcastsOnStackChangesForUser;

    /** @var string */
    private $stackUuid;

    public function __construct(string $stackUuid, string $userUuid)
    {
        $this->stackUuid = $stackUuid;

        $this->userUuid = $userUuid;
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
