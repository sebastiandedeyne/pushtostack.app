<?php

namespace App\Http\Middleware;

use App\Projections\Link;
use App\Scopes\UserScope;
use App\Projections\Stack;
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
