<?php

namespace App\Http\Controllers\Forum;

use App\User;
use App\UserFollowers;
use App\ForumCategories;
use App\ForumPosts;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Notification;

trait CreatingThreads
{
    /**
     * Handle a thread create request.
     *
     * @param  Illuminate\Http\Request $Request
     *
     * @return void
     */
    public function createThread(Request $Request)
    {
        // Validate the creating thread request.
        $this->threadRequestValidate($Request);

        // Check if the category is exist.
        if ($this->categoryIsValid($Request)) {
            // Store the thread into the database.
            $thread = $this->storeThread($Request);

            // Send the notifications to user's followers.
            foreach ($this->userFollowers() as $follower) {
                $this->sendNotification(User::find($follower->user_id), $thread);
            }

            // And then redirect him to the newly-created thread.
            return $this->createThreadSuccessful($Request, $thread);
        }

        // The category is not valid, redirect him back with some errors.
        return $this->createThreadFailed($Request, [
            'content' => 'Category not found.',
        ]);
    }

    /**
     * Redirect user to the thread
     *
     * @param  Illuminate\Http\Request $Request
     * @param  App\ForumPosts $thread
     *
     * @return Illuminate\Http\Response
     */
    protected function createThreadSuccessful(Request $Request, ForumPosts $thread)
    {
        return redirect()->route('thread', [$thread->id]);
    }

    /**
     * Send a failed to create a thread message.
     *
     * @param  Illuminate\Http\Request $Request
     * @param  Array  $message
     *
     * @return Illuminate\Validation\ValidationException
     */
    protected function createThreadFailed(Request $Request, $message)
    {
        throw ValidationException::withMessages($message);
    }

    /**
     * Validate thread inputs.
     *
     * @param  Illuminate\Http\Request $Request
     *
     * @return void
     */
    protected function threadRequestValidate(Request $Request)
    {
        return $this->validate($Request, [
            'title'   => 'required|min:50|max:70',
            'content' => 'required|min:50|max:255',
        ], [
            'title.required'   => 'The thread\'s title is required.',
            'title.max'        => 'The thread\'s title is too long.',
            'title.min'		      => 'The thread\'s title is too short.',
            'content.required' => 'The thread\'s content is required.',
            'content.max'      => 'The thread\'s content is too long.',
            'content.min'	     => 'The thread\'s content is too short.',
        ]);
    }

    /**
     * Get the creating thread request content
     *
     * @param  Illuminate\Http\Request $Request
     *
     * @return array
     */
    protected function threadRequestContent(Request $Request)
    {
        return [
            'category_id' => $Request->get('category'),
            'title'       => $Request->get('title'),
            'content'     => $Request->get('content'),
            'user_id'     => $this->id()
        ];
    }

    /**
     * Store the thread to the database.
     *
     * @param  Illuminate\Http\Request $Request
     *
     * @return App\ForumPosts
     */
    protected function storeThread(Request $Request)
    {
        return ForumPosts::create($this->threadRequestContent($Request));
    }

    /**
     * Send notification to user's follower.
     * when the thread is created successfully.
     *
     * @param App\User       $user
     * @param App\ForumPosts $thread
     *
     * @return void
     */
    protected function sendNotification(User $user, ForumPosts $thread)
    {
        return $user->notify(new UserNotification([
            'from'    => $this->username(),
            'route'   => 'thread',
            'param'   => $thread->id,
            'content' => $this->username().' just created a new thread!',
        ]));
    }

    /**
     * Check if the category is exist.
     *
     * @param  Illuminate\Http\Request $Request
     *
     * @return boolean
     */
    protected function categoryIsValid(Request $Request)
    {
        return ForumCategories::CategoryExist($this->threadRequestContent($Request)['category_id']);
    }

    /**
     * Return user's followers.
     *
     * @return App\UserFollowers
     */
    protected function userFollowers()
    {
        return UserFollowers::followers_list($this->id());
    }
}
