<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ForumPosts extends Model
{
    const max_display = 5; // phân trang cho result
    const timezone = 'Asia/Damascus'; // múi giờ, dùng cho Carbon datetime (xx days ago)

    protected $table = 'forum_posts';

    protected $fillable = ['post_id', 'parent_id', 'category_id', 'user_id', 'title', 'content'];

    /**
     * method ago
     * @param datetime $date
     * @return string hiện tại cách $date bao nhiêu ngày
     */
    public static function ago ($date)
    {
        $now = Carbon::now(self::timezone);
        return (new Carbon($date))->diffInDays($now);
    }

    /**
     * public method search
     * @param  string $keyword
     * @return object (paginated) post
     */
    public static function search ($keyword)
    {
        return self::where('title', 'like', '%'.$keyword.'%')->orWhere('content', 'like', '%'.$keyword.'%')->paginate(self::max_display);
    }

    /**
     * method threads
     * @param int $category_id
     * @return object tổng số thread trong 1 category.
     */
    public static function threads ($category_id)
    {
    	return self::where([
    		['category_id', '=', $category_id],
    		['parent_id', '=', 0]
    	])->orderBy('created_at', 'DESC')->paginate(self::max_display);
    }

    /**
     * method thread
     * @param int $thread_id
     * @return object content của 1 thread, bao gồm tất cả các post.
     */
    public static function thread ($thread_id) // this return all in a thread: main thread and posts
    {
    	return [
    		'thread' => self::where(
    			[
    				['post_id', '=', $thread_id],
    				['parent_id', '=', 0]
    			]
    		)->firstOrFail(),
    		'posts' => self::posts($thread_id)
    	];
    }
    /**
     * method post
     * @param int $post_id
     * @return object content của 1 post.
     */
    public static function post ($post_id)
    {
        return self::where('post_id', $post_id)->firstOrFail();
    }

    /**
     * private method posts
     * @param int $parent
     * @return object content của tất cả các post trong $parent thread.
     */
    private static function posts ($parent)
    {
    	return self::where(
    		[
    			['parent_id', '=', $parent],
    			['category_id', '=', 0]
    		]
    	)->paginate(self::max_display);
    }
}
