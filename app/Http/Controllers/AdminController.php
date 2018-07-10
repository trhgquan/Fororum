<?php

namespace App\Http\Controllers;

use App\UserBlacklists;
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
        $xpire  = ($Request->get('action') === 'accept') ? $Request->get('expire') : '';

        if ($Request->get('action') === 'accept')
        {
            UserBlacklists::ban(UserReport::report_information($id)->participant_id, $xpire);
        }
        UserReport::review($id, $action); // review the reports;

        return redirect()->back()->withErrors([
            'class' => ($Request->get('action') === 'accept') ? 'danger' : 'info',
            'content' => 'Đã ' . $action . ' báo cáo của người dùng thành công.'
        ]);
    }
}
