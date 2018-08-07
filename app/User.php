<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const max_display = 5; // hiện max_display user lúc tìm kiếm

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * static method exist.
     *
     * @param int or string $credentials (uid hoặc username đều được)
     *
     * @return bool
     */
    public static function exist($credentials)
    {
        return self::where('username', $credentials)->orWhere('id', $credentials)->exists();
    }

    /**
     * method username.
     *
     * @param int $id
     *
     * @return string
     */
    public static function username($id)
    {
        return self::where('id', $id)->firstOrFail()->username; // if the user is not found then 404
    }

    /**
     * static method Profile.
     *
     * @param  string
     *
     * @return object
     */
    public static function profile($credentials)
    {
        return self::where('username', $credentials)->firstOrFail();
    }

    /**
     * method userPosts.
     *
     * @param int $id
     *
     * @return object
     */
    public static function userPosts($id)
    {
        return [
            'threads' => ForumPosts::where([
                ['user_id', '=', $id],
                ['parent_id', '=', 0],
            ])->get(),
            'posts' => ForumPosts::where([
                ['user_id', '=', $id],
                ['category_id', '=', 0],
            ])->get(),
        ];
    }

    /**
     * method User search.
     *
     * @param string $keyword
     *
     * @return object
     */
    public static function search($keyword)
    {
        return self::where('username', 'like', '%'.$keyword.'%')->paginate(self::max_display);
    }
}
