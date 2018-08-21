<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait ThrottlesLogins
{
    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  Illuminate\Http\Request $Request
     * @return boolean
     */
    protected function hasTooManyLoginAttempts(Request $Request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($Request), $this->maxAttempts()
        );
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param  Illuminate\Http\Request $Request
     * @return void
     */
    protected function fireLockoutEvent(Request $Request)
    {
        event(new Lockout($Request));
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  Illuminate\Http\Request $Request
     * @return void
     */
    protected function incrementLoginAttempts(Request $Request)
    {
        $this->limiter()->hit(
            $this->throttleKey($Request), $this->decayMinutes()
        );
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  Illuminate\Http\Request $Request
     * @return void
     * @throws Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $Request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($Request)
        );

        throw ValidationException::withMessages([
            'username' => [Lang::get('auth.throttle', ['seconds' => $seconds])],
        ])->status(429);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  Illuminate\Http\Request $Request
     * @return void
     */
    protected function clearLoginAttempts(Request $Request)
    {
        $this->limiter()->clear($this->throttleKey($Request));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(Request $Request)
    {
        return Str::lower($Request->input('username')).'|'.$Request->ip();
    }

    /**
     * Get the RateLimiter instance
     *
     * @return Illuminate\Cache\RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    /**
     *  Get the number of minutes to throttle for.
     *
     * @return int
     */
    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }
}
