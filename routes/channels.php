<?php

use App\Domain\Stack\Models\Stack;
use App\Domain\User\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('stack_changes_for_user_{user_uuid}', function (User $user, string $userUuid) {
    return $userUuid === $user->uuid;
});

Broadcast::channel('link_changes_in_stack_{stack_uuid}', function (User $user, string $stackUuid) {
    return Stack::findByUuid($stackUuid)->user_uuid === $user->uuid;
});
