<?php

namespace App\Policies;

use App\Projections\Link;
use App\Projections\User;

class LinkPolicy
{
    public function delete(User $user, Link $link): bool
    {
        return $user->id === $link->user_id;
    }
}
