<?php

namespace App\Domain\Stack\Models;

use App\Support\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
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

        self::saving(function (self $tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Link::class);
    }
}
