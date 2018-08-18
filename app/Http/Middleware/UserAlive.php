<?php

namespace App\Http\Middleware;

use App\User;
use App\UserBlacklists;
use App\Userinformation;
use Carbon\Carbon;
use Closure;

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

        if (auth()->check() && UserInformation::userPermissions(auth()->id())['banned']) {
            // this is the reason why he get banned
            $reason = UserBlacklists::reason(auth()->id());
            // log him out
            auth()->logout();
            // and clear the session cache.. this will prevent the login bug.
            $request->session()->flush();

            return redirect()->route('auth.login')->withErrors(['title' => 'Error', 'content' => 'Your account has been banned by '.User::username($reason->admin_id).'. Date the ban will be lifted: '.date_format((new Carbon($reason->expire)), 'h:i:s A T, d-m-Y'), 'class' => 'danger']);
        }

        return $response;
    }
}
