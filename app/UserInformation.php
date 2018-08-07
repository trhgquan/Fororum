<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $table = 'users_information';

    protected $fillable = ['id', 'confirmed', 'permissions'];

    protected $hidden = [];

    /**
     * get all user active.
     * "active" means this user is not banned and not an admin.
     *
     * @return object
     */
    public static function getActiveUsers()
    {
        // 0 when user is banned and 2 when user is an admin
        return self::where([
            ['permissions', '<>', '2'],
            ['permissions', '<>', '0'],
        ])->paginate(5);
    }

    /**
     * method userPermissions.
     *
     * @param int $id
     *
     * @return array
     */
    public static function userPermissions($id)
    {
        return [
            'admin'     => self::userAdmin($id),
            'banned'    => self::userBanned($id),
            'confirmed' => self::userConfirmed($id),
            'mod'       => self::userMod($id),
        ];
    }

    /**
     * protected method userBanned.
     *
     * @param int $id
     *
     * @return bool
     */
    protected static function userBanned($id)
    {
        return self::find($id)->permissions == 0;
    }

    /**
     * protected method userConfirmed.
     *
     * @param int $id
     *
     * @return bool
     */
    protected static function userConfirmed($id)
    {
        return self::find($id)->confirmed == 1;
    }

    /**
     * protected method userAdmin.
     *
     * @param int $id
     *
     * @return bool
     */
    protected static function userAdmin($id)
    {
        return self::find($id)->permissions == 2;
    }

    /**
     * protected method userMod.
     *
     * @param int $id
     *
     * @return bool
     */
    protected static function userMod($id)
    {
        return self::find($id)->permissions == 3;
    }
}
