<?php

namespace App\Projections;

use App\Support\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuid;
    use Notifiable;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stacks(): HasMany
    {
        return $this->hasMany(Stack::class);
    }

    public function getInboxAttribute(): Stack
    {
        return $this->stacks->first();
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
