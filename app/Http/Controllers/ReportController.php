<?php

namespace App\Http\Controllers;

use App\ForumPosts;
use App\User;
use App\UserReport;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Always need some comments on this Controller
    // Just because it is the biggest waste of my time.

    /**
     * return the VIEW to report a profile
     * @param  string $username
     * @return null
     */
    public function profile ($username)
    {
        if (User::exist($username) && $username !== Auth::user()->username && UserReport::reportable(Auth::id(), User::profile($username)->id, 'profile'))
        {
            if (!UserReport::is_reported(Auth::id(), User::profile($username)->id, 'profile'))
            {
                return view('report', [
                    'type' => 'report',
                    'section' => 'profile',
                    'ppid' => User::profile($username)->id
                ]);
            }
            return view('report', ['type' => 'after']);
        }
        return view('report', ['type' => 'error']);
    }

    /**
     * return the VIEW to report a post
     * you can also report a thread
     * @param  int $post_id
     * @return null
     */
    public function post ($post_id)
    {
        if (ForumPosts::exist($post_id) && ForumPosts::post($post_id)->user_id !== Auth::id())
        {

            if (!UserReport::is_reported(Auth::id(), $post_id, 'post'))
            {
                return view('report', [
                    'type' => 'report',
                    'section' => 'post',
                    'ppid' => $post_id
                ]);
            }
            return view('report', ['type' => 'after']);
        }
        return view('report', ['type' => 'error']);
    }

    /**
     * now handle those POST requests in here!
     * @param  Illuminate\Http\Request $Request
     * @return null
     */
    public function handle (Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'ppid' => ['required'],
            'section' => ['required'],
            'reason'  => ['required', 'min:20','max:100']
        ], [
            'ppid.required'    => 'Vui lòng thử lại.',
            'section.required' => 'Vui lòng thử lại.',
            'reason.required'  => 'Không thể bỏ trống ô lý do.',
            'reason.min'       => 'Lý do quá ngắn.',
            'reason.max'       => 'Lý do quá dài.'
        ]);

        $fillable = ['profile', 'post'];

        if (!$validator->fails())
        {
            $participant_id = $Request->get('ppid');
            $reason = $Request->get('reason');
            $type   = $Request->get('section');
            if (UserReport::reportable(Auth::id(), $participant_id, $type))
            {
                if (!UserReport::is_reported(Auth::id(), $participant_id, $type))
                {
                    UserReport::create([
                        'participant_id' => $participant_id,
                        'user_id' => Auth::id(),
                        'type'    => $Request->get('section'),
                        'reason'  => $reason,
                    ]);
                    return redirect()->back()->withErrors(['reason' => 'Đã báo cáo tài khoản thành công']);
                }
                return redirect()->back()->withErrors(['reason' => 'Đã báo cáo tài khoản từ trước.']);
            }
            return redirect()->back()->withErrors(['reason' => 'Không thể báo cáo tài khoản của chính mình']);
        }
        return redirect()->back()->withErrors($validator);
    }
}
