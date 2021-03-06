<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    const max_display = 5; // max_display user for searching

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
     * @param int or string $credentials
     *
     * @return bool
     */
    public static function exist($credentials)
    {
        return self::where('username', $credentials)->orWhere('id', $credentials)->exists();
    }

    /**
     * static method recoverable.
     *
     * @param string $email
     *
     * @return mixed
     */
    public static function recoverable($email)
    {
        return self::where('email', $email)->exists();
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
