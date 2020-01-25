<?php

namespace App\Http\Controllers;

use App\ForumCategories;
use App\ForumPosts;
use App\Http\Controllers\Forum\CreatingPosts;
use App\Http\Controllers\Forum\CreatingThreads;

class ForumController extends Controller
{
    use CreatingPosts;
    use CreatingThreads;
    /**
     * users is not dead, duh.
     *
     * @return null
     */
    public function __construct()
    {
        $this->middleware('fororum.alive');
    }

    /**
     * return the home view.
     *
     * @return null
     */
    public function home()
    {
        return view('forum.pages.forum-home', ['records' => ForumCategories::ForumCategories()]);
    }

    /**
     * return the category.
     *
     * @param string $category
     *
     * @return mixed
     */
    public function category($category)
    {
        if (ForumCategories::CategoryExist($category)) {
            // get the category's info
            $categoryObj = ForumCategories::Category($category);

            // get all the threads of category.
            $category_threads = ForumPosts::threads($categoryObj->id);

            if ($this->paginateCheck($category_threads)) {
                return view('forum.pages.forum-category', [
                    'category_name'    => $categoryObj->title,
                    'category_keyword' => $categoryObj->keyword,
                    'category_id'      => $categoryObj->id,
                    'category_threads' => $category_threads,
                ]);
            }

            return redirect()->route('category', [$categoryObj->keyword]);
        }

        return abort(404);
    }

    /**
     * return the thread's content.
     *
     * @param int $thread_id
     *
     * @return null
     */
    public function thread($thread_id)
    {
        $thread = ForumPosts::thread($thread_id);

        if ($this->paginateCheck($thread['posts'])) {
            return view('forum.pages.forum-display', ['thread' => true, 'content' => $thread]);
        }
        // this return to the last page, cause everything new on the forum
        // is always in the last page.
        return redirect()->route('thread', ['thread_id' => $thread_id, 'page' => $thread['posts']->lastPage()]);
    }

    /**
     * return the post's content.
     *
     * @param int $post_id
     *
     * @return null
     */
    public function post($post_id)
    {
        return view('forum.pages.forum-display', ['thread' => false, 'content' => ForumPosts::post($post_id)]);
    }
}
