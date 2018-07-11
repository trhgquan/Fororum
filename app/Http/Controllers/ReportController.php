<?php

namespace App\Http\Controllers;

use App\ForumPosts;
use App\User;
use App\UserReport;
use Auth;
use Validator;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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
