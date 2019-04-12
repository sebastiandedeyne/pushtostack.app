<?php

namespace App\Domain\Stack\Models;

use App\Support\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'id', 'user_id'
    ];
}
