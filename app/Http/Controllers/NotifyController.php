<?php

namespace App\Http\Controllers;

use App\UserNotification;
use Auth;

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
        $custom_notify = UserNotification::custom_notify($notify_id);
        $notify_route = UserNotification::route_check($custom_notify);
        if ($custom_notify->user_id == Auth::id() && empty($custom_notify->open)) {
            $custom_notify->open = true;
            $custom_notify->save();

            return redirect()->route($notify_route['route'], [$notify_route['param']]);
        }

        return abort(404);
    }
}
