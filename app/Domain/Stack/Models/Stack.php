<?php

namespace App\Domain\Stack\Models;

use App\Support\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Stack extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'id', 'user_id'
    ];

    protected $appends = [
        'tags', 'link_count'
    ];

    public static function getInbox(string $userUuid): self
    {
        return self::where('user_uuid', $userUuid)->firstOrFail();
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function getTagsAttribute(): array
    {
        return $this->links
            ->flatMap->tags
            ->unique('id')
            ->map(function (Tag $tag) {
                return [
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'link_count' => $tag->links()
                        ->where('stack_id', $this->id)
                        ->count(),
                ];
            })
            ->sortBy('name')
            ->values()
            ->toArray();
    }

    public function getLinkCountAttribute(): int
    {
        return $this->links()->count();
    }
}
