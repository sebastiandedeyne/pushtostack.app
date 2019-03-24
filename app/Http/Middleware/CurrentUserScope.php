<?php

namespace App\Http\Middleware;

use App\Link;
use App\Scopes\UserScope;
use App\Stack;
use Closure;

class CurrentUserScope
{
    public function handle($request, Closure $next)
    {
        $userScope = new UserScope($request->user());

        Link::addGlobalScope($userScope);
        Stack::addGlobalScope($userScope);

        return $next($request);
    }
}
