<?php

namespace App\Scopes;

use App\Projections\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    /** @var \App\Models\User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('user_id', $this->user->id);
    }
}
