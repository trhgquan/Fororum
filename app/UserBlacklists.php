<?php

namespace App;

use App\UserInformation;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserBlacklists extends Model
{
    const admin_id = 1; // admin id default: 1

    protected $table = 'user_blacklists';

    protected $fillable = ['user_id', 'admin_id', 'expire'];

    public static function ban ($credential, $until)
    {
        if (!UserInformation::userPermissions($credential)['banned'])
        {
            $expire = self::until($until);
            self::create([
                'user_id'  => $credential,
                'admin_id' => self::admin_id,
                'expire'   => $expire
            ]);
            $user = UserInformation::where('id', $credential)->first();
            $user->permissions = 0;
            $user->save();
        }
    }

    public static function unban ($credential)
    {
        self::where('user_id', $credential)->delete();

        $user = UserInformation::find($credential);
        $user->permissions = 1;
        $user->save();
    }

    public static function reason ($credential)
    {
        return self::where('user_id', $credential)->first();
    }

    /**
     * method checkIfExpired
     * check if user ban has expire.
     * @param  int $credential
     * @return false if user not banned.
     * @return true if user banned and
     */
    public static function checkIfExpired ($credential)
    {
        $expire = self::where('user_id', $credential);
        return (Carbon::now() > self::until($expire->first()->expire));
    }

    private static function until ($expire)
    {
        return (new Carbon($expire));
    }
}
