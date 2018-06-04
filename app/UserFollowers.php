<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollowers extends Model
{
    protected $table = 'users_followers';

    protected $fillable = ['id', 'user_id', 'participant_id'];

    /**
     * static method is_followed
     * @param  int  $uid
     * @param  int  $pid
     * @return boolean true nếu uid đã follow pid, false là ngược lại.
     */
    public static function is_followed ($uid, $pid)
    {
        return self::where('user_id', $uid)->where('participant_id', $pid)->exists();
    }

    /**
     * static method followers
     * @param  int $uid
     * @return int số người follow của uid.
     */
    public static function followers ($uid)
    {
        return self::where('participant_id', $uid)->count();
    }

    /**
     * static method followers_list
     * @param  int $uid
     * @return object list of user's followers
     */
    public static function followers_list ($uid)
    {
        return self::where('participant_id', $uid)->orderBy('user_id', 'ASC')->get();
    }

    /**
     * static method following
     * @param  int $uid
     * @return int số người mà uid follow.
     */
    public static function following ($uid)
    {
        return self::where('user_id', $uid)->count();
    }

    /**
     * static method follow
     * @param  int $uid
     * @param  int $pid
     * @return null (Action method)
     */
    public static function follow ($uid, $pid)
    {
        if (!self::is_followed($uid, $pid))
        {
            self::create([
                'user_id' => $uid,
                'participant_id' => $pid
            ]);
        }
        else
        {
            self::where([
                'user_id' => $uid,
                'participant_id' => $pid
            ])->delete();
        }
    }
}
