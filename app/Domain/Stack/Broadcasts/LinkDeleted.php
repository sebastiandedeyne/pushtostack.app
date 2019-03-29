<?php

namespace App\Domain\Stack\Broadcasts;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LinkDeleted implements ShouldBroadcast
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

    public function broadcastAs()
    {
        return 'link_deleted';
    }
}
