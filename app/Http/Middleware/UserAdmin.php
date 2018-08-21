<?php

namespace App\Http\Middleware;

use App\UserInformation;
use Closure;

class UserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !UserInformation::userPermissions(auth()->id())['admin']) {
            return abort(404);
        }

        return $next($request);
    }
}
