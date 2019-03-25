<?php

namespace App\Events;

use App\Link;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class TitleFetched extends DataTransferObject implements ShouldBeStored, ShouldBroadcast
{
    /** @var string */
    public $link_uuid;

    /** @var string */
    public $title;

    public function broadcastOn()
    {
        $link = Link::findByUuid($this->link_uuid);

        return new PrivateChannel("stacks.{$link->stack->uuid}");
    }

    public function broadcastAs()
    {
        return 'title_fetched';
    }
}
