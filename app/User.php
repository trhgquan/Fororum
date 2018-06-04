<?php

namespace App;

use App\ForumPosts;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'name', 'email', 'password', 'username'
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
     * static method exist
     * @param  int or string $credentials (uid hoặc username đều được)
     * @return bool true nếu user tồn tại, false nếu không
     */
    public static function exist ($credentials)
    {
        return self::where('username', $credentials)->orWhere('id', $credentials)->exists();
    }

    /**
     * static method Profile
     * @param  int or string $credentials (username hoặc userid)
     * @return object profile của user
     */
    public static function profile($credentials)
    {
        return self::where('username', $credentials)->firstOrFail();
    }

    /**
     * method username
     * @param int $id
     * @return string username của người dùng
     */
    public static function username($id)
    {
        return self::where('id', $id)->first()->username;
    }

    /**
     * method userPosts
     * @param int $id
     * @return object threads và posts của người dùng. dùng count() để lấy tổng số thread và post.
     */
    public static function userPosts ($id)
    {
        return [
            'threads' => ForumPosts::where([
                ['user_id', '=', $id],
                ['parent_id', '=', 0]
            ])->get(),
            'posts' => ForumPosts::where([
                ['user_id', '=', $id],
                ['category_id', '=', 0]
            ])->get()
        ];
    }

    /**
     * method User search
     * @param  string $keyword
     * @return object thông tin của user, đã được paginated
     */
    public static function search ($keyword)
    {
        return self::where('username', 'like', '%'.$keyword.'%')->paginate(self::max_display);
    }
}
