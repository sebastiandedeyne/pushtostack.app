<?php

namespace App\Domain\Stack\Broadcasts;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Domain\Stack\Broadcasts\Concerns\BroadcastsOnLinkChangesInStack;

class LinkDeleted implements ShouldBroadcast
{
    use BroadcastsOnLinkChangesInStack;

    /** @var string */
    private $linkUuid;

    public function __construct(string $linkUuid, string $stackUuid)
    {
        $this->linkUuid = $linkUuid;

        $this->stackUuid = $stackUuid;
    }

    public function broadcastWith()
    {
        return ['uuid' => $this->linkUuid];
    }

    public function broadcastAs()
    {
        return 'link_deleted';
    }
}
