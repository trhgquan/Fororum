<?php

namespace App\Http\Controllers\Forum;

use App\ForumPosts;
use App\Http\Controllers\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait CreatingPosts
{
    use RedirectsUsers;

    /**
     * Handle a create-post Request.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return void
     */
    public function createPost(Request $Request)
    {
        // Validate the post request.
        $this->postRequestValidate($Request);

        // Check if user is replying to a valid thread.
        if ($this->threadIsValid($Request)) {
            // Store the post to database
            $post = $this->storePost($Request);

            // Redirect the user to the thread's last page, if the post was created successfully.
            return $this->createPostSuccessful($Request, $post);
        }

        // Redirect the user back with errors.
        return $this->createPostFailed($Request, [
            'content' => 'The parent thread could not be found.',
        ]);
    }

    /**
     * Validate post inputs.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return void
     */
    protected function postRequestValidate(Request $Request)
    {
        return $this->validate($Request, [
            'content' => 'required|min:50|max:255',
        ], [
            'content.required' => 'The post\'s content field is required.',
            'content.max'      => 'The post\'s content is too long.',
            'content.min'	     => 'The post\'s content is too short.',
        ]);
    }

    /**
     * Get the new post's data.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return array
     */
    protected function postRequestContent(Request $Request)
    {
        return [
            'content'     => $Request->get('content'),
            'parent_id'   => $Request->get('parent'),
            'user_id'     => $this->id(),
        ];
    }

    /**
     * Check if user is replying to a valid thread, not a comment.
     *
     * @param Illuminate\Http\Request $ParentThread
     *
     * @return bool
     */
    protected function threadIsValid(Request $ParentThread)
    {
        // the parent thread have parent_id = 0;
        // and also, the parent thread's id is not 0.
        return !empty($ParentThread->parent) && empty($this->parent($ParentThread->parent));
    }

    /**
     * Store the post to the database.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return App\ForumPosts
     */
    protected function storePost(Request $Request)
    {
        return ForumPosts::create($this->postRequestContent($Request));
    }

    /**
     * Redirect user to the last page of the thread
     * if a post was successfully created.
     *
     * @param Illuminate\Http\Request $Request
     * @param App\ForumPosts          $post
     *
     * @return Illuminate\Http\Response
     */
    protected function createPostSuccessful(Request $Request, ForumPosts $post)
    {
        return redirect()->route('thread', [
            'thread_id' => $this->parent($post->id),
            'page'      => $this->threadLastPage($this->parent($post->id)),
        ]);
    }

    /**
     * Send a failed to create a post message.
     *
     * @param Illuminate\Http\Request $Request
     * @param array                   $message
     *
     * @return Illuminate\Validation\ValidationException
     */
    protected function createPostFailed(Request $Request, array $message)
    {
        throw ValidationException::withMessages($message);
    }

    /**
     * Get the last page of a thread.
     *
     * @param int $thread
     *
     * @return void
     */
    protected function threadLastPage(int $thread)
    {
        return ForumPosts::thread($thread)['posts']->lastPage();
    }

    /**
     * Return the parent thread of a post.
     *
     * @param int $post
     *
     * @return App\ForumPosts
     */
    protected function parent($post)
    {
        return ForumPosts::post($post)->parent_id;
    }

    /**
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

    /**
     * Return authenticated user's username.
     *
     * @return void
     */
    public function username()
    {
        return Auth::user()->username;
    }

    /**
     * Return authenticated user's identity.
     *
     * @return void
     */
    public function id()
    {
        return Auth::id();
    }
}
