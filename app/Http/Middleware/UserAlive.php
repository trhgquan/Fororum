<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\MessageBag;
use App\User;
use App\Userinformation;
use App\UserBlacklists;
use Carbon\Carbon;

class UserAlive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && UserInformation::userPermissions(Auth::id())['banned'])
        {
            // this is the reason why
            // he get banned
            $reason = UserBlacklists::reason(Auth::id());
            Auth::logout();
            return redirect()->route('login')->withErrors(['title' => 'Lỗi', 'content' => 'Tài khoản của bạn đã bị khóa bởi ' . User::username($reason->admin_id) . ' và sẽ được mở khóa vào lúc ' . date_format((new Carbon($reason->expire)), 'h:i:s A T, d-m-Y'), 'class' => 'warning']);
        }

        return $response;
    }
}
