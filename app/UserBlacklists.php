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

    /**
     * ban procedure
     * @param  int $credential User id
     * @param  datetime $until expired
     */
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
            $user = UserInformation::find($credential);
            $user->permissions = 0;
            $user->save();
        }
    }

    /**
     * unban procedure
     * @param  int $credential user id
     */
    public static function unban ($credential)
    {
        self::where('user_id', $credential)->delete();

        $user = UserInformation::find($credential);
        $user->permissions = 1;
        $user->save();
    }

    /**
     * method reason
     * @param  int $credential user id
     * @return object
     */
    public static function reason ($credential)
    {
        return self::where('user_id', $credential)->first();
    }

    /**
     * method checkIfExpired
     * check if user ban has expire.
     * @param  int $credential
     * @return false if user ban has not expired.
     * @return true if user ban has expired
     */
    public static function checkIfExpired ($credential)
    {
        $expire = self::where('user_id', $credential);
        return (Carbon::now() > self::until($expire->first()->expire));
    }

    /**
     * private method until
     * return expire date
     * @param  Carbon datetime $expire
     * @return Carbon\Carbon date
     */
    private static function until ($expire)
    {
        return (new Carbon($expire));
    }
}
