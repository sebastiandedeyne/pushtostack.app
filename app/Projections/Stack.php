<?php

namespace App\Projections;

use App\Events\Broadcasts\StackCreated;
use App\Events\Broadcasts\StackDeleted;
use App\Events\Broadcasts\StackUpdated;
use App\Support\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'id', 'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function (self $stack) {
            event(new StackCreated($stack));
        });

        self::updated(function (self $stack) {
            event(new StackUpdated($stack));
        });

        self::deleted(function (self $stack) {
            event(new StackDeleted($stack->uuid));
        });
    }
}
