<?php

use Illuminate\Support\Str;

function uuid(): string
{
    return (string) Str::uuid();
}
