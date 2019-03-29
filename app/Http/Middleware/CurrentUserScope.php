<?php

namespace App\Http\Middleware;

use App\Domain\Stack\Models\Link;
use App\Domain\Stack\Models\Stack;
use App\Domain\Stack\Scopes\UserScope;
use Closure;

class CurrentUserScope
{
    public function handle($request, Closure $next)
    {
        $userScope = new UserScope($request->user()->uuid);

        Link::addGlobalScope($userScope);
        Stack::addGlobalScope($userScope);

        return $next($request);
    }
}
