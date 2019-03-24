<?php

namespace App\Reactors;

use App\Events\StackCreated;
use App\Events\UserRegistered;
use Illuminate\Support\Str;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

class UsersReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        UserRegistered::class => 'onUserRegistered',
    ];

    public function onUserRegistered(UserRegistered $event)
    {
        event(new StackCreated([
            'uuid' => (string) Str::uuid(),
            'user_uuid' => $event->uuid,
            'name' => 'Inbox',
            'order' => 1,
        ]));
    }
}
