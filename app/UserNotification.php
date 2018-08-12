<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    const max_display = 5; // paginate

    protected $table = 'users_notification';

    protected $fillable = ['user_id', 'participant_id', 'route', 'content', 'open'];

    protected $hidden = [];

    /**
     * $primaryKey, for update method (controller).
     *
     * @var string
     */
    protected $primaryKey = 'notify_id';

    /**
     * static method route_check.
     *
     * @param object $notify
     *
     * @return array
     */
    public static function route_check($notify)
    {
        switch ($notify->route) {
            case 'profile':
                $Route = 'user.profile.username';
                $RouteParam = User::username($notify->participant_id);
                break;

            // more goes here

            default:
                $Route = 'post';
                $RouteParam = $notify->participant_id;
                break;
        }

        return [
            'route' => $Route,
            'param' => $RouteParam,
        ];
    }

    /**
     * static method count.
     *
     * @param int $user_id
     *
     * @return int
     */
    public static function count($user_id)
    {
        return self::where([
            ['user_id', '=', $user_id],
            ['open', '=', 0],
        ])->count();
    }

    /**
     * static method notify.
     *
     * @param int $user_id
     *
     * @return object
     */
    public static function notify($user_id)
    {
        return self::where([
            ['user_id', '=', $user_id],
            ['open', '=', 0],
        ])->orderBy('created_at', 'DESC')->paginate(self::max_display);
    }

    /**
     * static method custom_notify.
     *
     * @param int $notify_id
     *
     * @return object
     */
    public static function custom_notify($notify_id)
    {
        return self::where('notify_id', $notify_id)->firstOrFail();
    }
}
