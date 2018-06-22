<?php

namespace App\Http\Controllers;

use App\UserReport;
use App\UserNotification;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public function action (Request $Request)
    {
        $id = $Request->get('rpid');
        $action = ($Request->get('action') === 'accept') ? 'phê chuẩn' : 'bác bỏ';

        $report = UserReport::report_information($id);
        $report->reviewed = 1;
        $report->save();

        UserNotification::create([
            'user_id' => $report->user_id,
            'participant_id' => $report->participant_id,
            'route' => $report->type,
            'content' => 'Hệ thống đã xem xét và đã ' . $action . ' báo cáo của bạn về ' . (($report->type === 'profile') ? 'tài khoản ' : 'bài viết ') . UserReport::participant_title($report->participant_id, $report->type)
        ]);

        return redirect()->back()->withErrors([
            'class' => ($Request->get('action') === 'accept') ? 'success' : 'danger',
            'content' => 'Đã ' . $action . ' báo cáo của người dùng thành công.'
        ]);
    }
}
