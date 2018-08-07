<?php

namespace App\Http\Controllers;

use App\UserNotification;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    /**
     * redirect user to the notify's object.
     *
     * @param int $notify_id
     *
     * @return null|object
     */
    public function notify($notify_id)
    {
        // we need the notify content here.
        $custom_notify = UserNotification::custom_notify($notify_id);
        // the notify route.
        $notify_route = UserNotification::route_check($custom_notify);
        if ($this->openable($custom_notify)) {
            // this will uncheck the notify from un-read (0) to read (1)
            $custom_notify->open = true;
            $custom_notify->save();
            // then redirect to the notify route.
            return redirect()->route($notify_route['route'], [$notify_route['param']]);
        }

        return abort(404);
    }

    /**
     * private method openable
     * return true if this notify is for this user,
     * and the notify is not opened.
     *
     * @param UserNotification $notify
     *
     * @return bool
     */
    protected function openable(UserNotification $notify)
    {
        return $notify->user_id === Auth::id() && empty($notify->open);
    }
}
