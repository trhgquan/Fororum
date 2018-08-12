<?php

namespace App\Http\Middleware;

use App\User;
use App\UserBlacklists;
use App\Userinformation;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserAlive
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
        $response = $next($request);

        if (Auth::check() && UserInformation::userPermissions(Auth::id())['banned']) {
            // this is the reason why he get banned
            $reason = UserBlacklists::reason(Auth::id());
            Auth::logout();

            return redirect()->route('login')->withErrors(['title' => 'Error', 'content' => 'Your account has been banned by '.User::username($reason->admin_id).'. Date the ban will be lifted: '.date_format((new Carbon($reason->expire)), 'h:i:s A T, d-m-Y'), 'class' => 'danger']);
        }

        return $response;
    }
}
