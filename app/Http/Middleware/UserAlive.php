<?php

namespace App\Http\Middleware;

use App\Userinformation;
use Auth;
use Closure;
use Illuminate\Support\MessageBag;

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
            Auth::logout();
            return redirect()->route('login')->withErrors(new MessageBag(['title' => 'Lỗi', 'content' => 'Tài khoản của bạn đã bị ban khỏi hệ thống!', 'class' => 'warning']));
        }

        return $response;
    }
}
