<?php

namespace App\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;

class LinkAdded extends DataTransferObject implements ShouldBroadcast, ShouldBeStored
{
    /** @var string */
    public $link_uuid;

    /** @var string */
    public $user_uuid;

    /** @var string */
    public $stack_uuid;

    /** @var string */
    public $url;

    /** @var string|null */
    public $title;

    /** @var string */
    public $added_at;

    public function broadcastAs()
    {
        return 'link_added';
    }

    public function broadcastOn()
    {
        return new PrivateChannel("stacks.{$this->stack_uuid}");
    }
}
