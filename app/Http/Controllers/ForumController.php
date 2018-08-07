<?php

namespace App\Http\Controllers;

use App\ForumCategories;
use App\ForumPosts;
use App\User;
use App\UserFollowers;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Auth;
use Validator;

class ForumController extends Controller
{
    /**
     * users is not dead, duh.
     *
     * @return null
     */
    public function __construct()
    {
        $this->middleware('alive');
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
     * @param int|string $category
     *
     * @return null
     */
    public function category($category)
    {
        if (ForumCategories::CategoryExist($category)) {
            $categoryObj = ForumCategories::Category($category);
            $category_threads = ForumPosts::threads($categoryObj->id);
            if ($this->paginateCheck($category_threads)) {
                return view('forum.pages.forum-category', [
                    'category_name'    => $categoryObj->title,
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

    /**
     * create a post.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function createPost(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'content' => 'required|min:50|max:255',
        ], [
            'content.required' => 'Không được bỏ trống ô nội dung',
            'content.max'      => 'nội dung vượt quá độ dài cho phép',
            'content.min'	     => 'nội dung quá ngắn',
        ]);

        if (!$validator->fails()) {
            $parent = $Request->get('parent');
            if (!empty($parent) && empty(ForumPosts::post($parent)->parent_id)) { // parent phải là 1 thread, mà thread thì parent_id = 0
                $parent = ForumPosts::post($parent);
                $post = ForumPosts::create([
                    'parent_id' => $parent->post_id,
                    'user_id'   => Auth::id(),
                    'content'   => $Request->get('content'),
                ]);
                // redirect tới trang cuối của thread
                return redirect()->route('thread', [
                    'thread_id' => $parent->post_id,
                    'page'      => ForumPosts::thread($parent->post_id)['posts']->lastPage(),
                ]);
            }

            return redirect()->back()->withErrors(['errors' => 'Không tìm thấy chủ đề!']);
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }

    /**
     * create a thread.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function createThread(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'title'   => 'required|min:50|max:70',
            'content' => 'required|min:50|max:255',
        ], [
            'title.required'   => 'không thể để trống tiêu đề',
            'title.max'        => 'tiêu đề quá dài',
            'title.min'		      => 'tiêu đề quá ngắn',
            'content.required' => 'không thể để trống nội dung',
            'content.max'      => 'nội dung quá dài',
            'content.min'	     => 'nội dung quá ngắn',
        ]);

        if (!$validator->fails() && ForumCategories::CategoryExist($Request->get('category'))) { // subforum phải tồn tại
            $thread = ForumPosts::create([
                'category_id' => $Request->get('category'),
                'user_id'     => Auth::id(),
                'title'       => $Request->get('title'),
                'content'     => $Request->get('content'),
            ]);
            foreach (UserFollowers::followers_list(Auth::id()) as $followers) {
                UserNotification::create([
                    'user_id'        => $followers->user_id,
                    'participant_id' => $thread->id,
                    'route'          => 'thread',
                    'content'        => User::username($followers->participant_id).' vừa tạo một chủ đề mới!',
                ]);
            }

            return redirect()->route('thread', [$thread->id]); // tương tự: id là primary key của table
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }

    /**
     * method paginateCheck
     * check if this page is not the infinitive non-exist page.
     *
     * @param Illuminate\Pagination\LengthAwarePaginator $object
     *
     * @return bool
     */
    protected function paginateCheck(Paginator $object)
    {
        return $object->currentPage() <= $object->lastPage();
    }
}
