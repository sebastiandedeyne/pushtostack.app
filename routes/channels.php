<?php

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

Broadcast::channel('stack_changes_for_user_{user_uuid}', function () {
    return true;
});

Broadcast::channel('link_changes_in_stack_{stack_uuid}', function () {
    return true;
});
