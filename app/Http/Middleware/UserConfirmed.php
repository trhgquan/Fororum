<?php

namespace App\Http\Middleware;

use App\UserInformation;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserConfirmed
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
        if (Auth::check() && !UserInformation::userPermissions(Auth::id())['confirmed']) {
            return redirect()->back()->withErrors(['errors' => 'Your account must be verified to create new threads!']);
        }

        return $next($request);
    }
}
