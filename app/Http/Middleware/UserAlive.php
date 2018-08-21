<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\Authentication;
use App\User;
use App\UserBlacklists;
use App\UserInformation;
use Carbon\Carbon;
use Closure;

class UserAlive
{
    use Authentication;

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

        if (auth()->check()) {
            $permissions = UserInformation::userPermissions($this->id());
            if ($permissions['banned']) {
                // if the user is banned, and he is not expired yet.
                if (!UserBlacklists::checkIfExpired($this->id())) {
                    // this is the reason why he get banned
                    $reason = UserBlacklists::reason($this->id());
                    // log him out
                    return $this->logout($request, [
                        'title'   => 'Error',
                        'content' => 'Your account has been banned by '.User::username($reason->admin_id).'. Date the ban will be lifted: '.date_format((new Carbon($reason->expire)), 'h:i:s A T, d-m-Y'),
                        'class'   => 'danger',
                    ]);
                }
                // if not, unban for him. poor guy.
                UserBlacklists::unban($this->id());
            }
        }

        return $response;
    }

    /**
     * Return the authenticated user's id.
     *
     * @return int
     */
    protected function id()
    {
        return auth()->id();
    }
}
