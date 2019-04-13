<?php

namespace App\Domain\Stack\Models;

use App\Support\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function stack(): BelongsTo
    {
        return $this->belongsTo(Stack::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
