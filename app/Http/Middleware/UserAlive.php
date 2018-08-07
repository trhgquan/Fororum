<?php

namespace App\Http\Middleware;

use App\User;
use App\UserBlacklists;
use App\Userinformation;
use Auth;
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

        if (Auth::check() && UserInformation::userPermissions(Auth::id())['banned']) {
            // this is the reason why
            // he get banned
            $reason = UserBlacklists::reason(Auth::id());
            Auth::logout();

            return redirect()->route('login')->withErrors(['title' => 'Lỗi', 'content' => 'Tài khoản của bạn đã bị khóa bởi '.User::username($reason->admin_id).' và sẽ được mở khóa vào lúc '.date_format((new Carbon($reason->expire)), 'h:i:s A T, d-m-Y'), 'class' => 'warning']);
        }

        return $response;
    }
}
