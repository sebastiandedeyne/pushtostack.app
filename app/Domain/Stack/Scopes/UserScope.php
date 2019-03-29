<?php

namespace App\Domain\Stack\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    /** @var string */
    private $userUuid;

    public function __construct(string $userUuid)
    {
        $this->userUuid = $userUuid;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('user_uuid', $this->userUuid);
    }
}
