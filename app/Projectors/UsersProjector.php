<?php

namespace App\Projectors;

use App\Events\UserRegistered;
use App\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class UsersProjector implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        UserRegistered::class,
    ];

    public function onUserRegistered(UserRegistered $event)
    {
        User::create([
            'uuid' => $event->user_uuid,
            'name' => $event->name,
            'email' => $event->email,
            'password' => $event->password,
        ])->stacks()->create([
            'uuid' => $event->inbox_uuid,
            'name' => 'Inbox',
            'order' => 1,
        ]);
    }
}
