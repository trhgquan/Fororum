<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\ForumCategories;

class ForumPosts extends Model
{
    const max_display = 5; // result pagination

    protected $table = 'forum_posts';

    protected $fillable = ['post_id', 'parent_id', 'category_id', 'user_id', 'title', 'content'];

    /**
     * method ago
     * @param datetime $date
     * @return string
     */
    public static function ago ($date)
    {
        $now = Carbon::now();
        return (new Carbon($date))->diffInDays($now);
    }

    /**
     * static function exists
     * @param  int $post_id
     * @return bool
     */
    public static function exist ($post_id)
    {
        return self::where('post_id', $post_id)->exists();
    }

    /**
     * static method postTitle
     * @param  int $post_id
     * @return string
     */
    public static function postTitle ($post_id)
    {
        $title = self::where('post_id', $post_id)->first()->title;
        if (empty($title))
        {
            $parent_post = self::where('post_id', $post_id)->first()->parent_id;
            $title = 're: ' . self::postTitle($parent_post); // recursion yey!
        }
        return $title;
    }

    /**
     * public method search
     * @param  string $keyword
     * @return object
     */
    public static function search ($keyword)
    {
        return self::where('title', 'like', '%'.$keyword.'%')->orWhere('content', 'like', '%'.$keyword.'%')->orderBy('created_at', 'DESC')->paginate(self::max_display);
    }

    /**
     * method threads
     * for display only.
     * @param int $category_id
     * @return object
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
     * @return object
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
     * static function totalPosts
     * @param  int $thread_id
     * @return int
     */
    public static function totalPosts ($thread_id)
    {
        return self::where('parent_id', $thread_id)->count();
    }

    /**
     * method post
     * @param int $post_id
     * @return object
     */
    public static function post ($post_id)
    {
        return self::where('post_id', $post_id)->firstOrFail();
    }

    /**
     * method breadcrumbs
     * for thread and post.
     * @param  int $something_id
     * @return array
     */
    public static function breadcrumbs ($something_id)
    {
        if (!self::is_thread($something_id))
        {
            $parent = self::post($something_id)->parent_id;
            $ancestors = ForumCategories::Category(self::thread($parent)['thread']->category_id);
            return [
                'category' => [
                    'title' => $ancestors->title,
                    'id' => $ancestors->keyword
                ],
                'thread' => [
                    'title' => self::postTitle($parent),
                    'id'    => $parent
                ],
                'post' => [
                    'title' => self::postTitle($something_id),
                    'id'    => (int) $something_id
                ]
            ];
        }
        $ancestors = ForumCategories::Category(self::thread($something_id)['thread']->category_id);
        return [
            'category' => [
                'title' => $ancestors->title,
                'id' => $ancestors->keyword
            ],
            'thread' => [
                'title' => self::postTitle($something_id),
                'id'    => (int) $something_id
            ]
        ];
    }

    /**
     * private method posts
     * @param int $parent
     * @return object.
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

    /**
     * method is_thread
     * @param  int  $participant
     * @return boolean
     */
    private static function is_thread ($participant)
    {
        return self::where([
            ['post_id', '=', $participant],
            ['category_id', '<>', 0]
        ])->exists();
    }
}
