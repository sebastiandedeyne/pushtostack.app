<?php

namespace App\Projections;

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
}
