<?php

namespace App\Domain\User\Projectors;

use App\Domain\User\Models\User;
use App\Domain\User\UserRegistered;
use Spatie\EventProjector\Models\StoredEvent;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class UsersProjector implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        UserRegistered::class,
    ];

    public function onUserRegistered(UserRegistered $event): void
    {
        User::create([
            'uuid' => $event->user_uuid,
            'name' => $event->name,
            'email' => $event->email,
            'password' => $event->password,
        ]);
    }

    public function hasReceivedAllPriorEvents(StoredEvent $storedEvent): bool
    {
        return true;
    }

    public function hasReceivedAllEvents(): bool
    {
        return true;
    }
}
