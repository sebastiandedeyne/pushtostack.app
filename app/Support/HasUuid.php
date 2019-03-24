<?php

namespace App\Support;

trait HasUuid
{
    /** @return static */
    public static function findByUuid(string $uuid)
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }
}
