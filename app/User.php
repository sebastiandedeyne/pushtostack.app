<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\HasUuid;

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

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
