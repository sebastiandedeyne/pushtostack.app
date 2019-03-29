<?php

namespace App\Projections;

use App\Events\Broadcasts\LinkCreated;
use App\Events\Broadcasts\LinkDeleted;
use App\Events\Broadcasts\LinkUpdated;
use App\Support\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'id', 'user_id', 'stack', 'stack_id'
    ];

    protected $casts = [
        'added_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function (self $link) {
            event(new LinkCreated($link));
        });

        self::updated(function (self $link) {
            event(new LinkUpdated($link));
        });

        self::deleted(function (self $link) {
            event(new LinkDeleted($link->uuid, $link->stack_uuid));
        });
    }

    public function stack(): BelongsTo
    {
        return $this->belongsTo(Stack::class);
    }
}
