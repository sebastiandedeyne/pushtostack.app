<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\HasUuid;
use App\Events\Broadcast\LinkUpdated;

class Link extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'id', 'user_id', 'stack_id'
    ];

    protected $casts = [
        'added_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (self $link) {
            event(new LinkUpdated($link));
        });

        static::updated(function (self $link) {
            event(new LinkUpdated($link));
        });
    }

    public function stack(): BelongsTo
    {
        return $this->belongsTo(Stack::class);
    }
}
