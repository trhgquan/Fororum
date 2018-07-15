<?php

namespace App\Http\Controllers;

use App\UserBlacklists;
use App\UserReport;
use App\UserNotification;
use App\ForumCategories;
use App\ForumPosts;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public function createSubforum (Request $Request)
    {
        $validator = Validator::make([
            'title' => $Request->get('subforum_title'),
            'description' => $Request->get('subforum_description'),
            'keyword' => $Request->get('subforum_keyword'),
            'confirm' => $Request->get('confirm')
        ], [
            'title'   => ['required', 'max:40'],
            'description'   => ['required', 'min:40'],
            'keyword' => ['required', 'unique:forum_categories,keyword', 'max:40', 'regex:/^[A-Za-z0-9-]+$/'],
            'confirm' => ['accepted']
        ]);
        if (!$validator->fails())
        {
            $category = ForumCategories::create([
                'title' => $Request->get('subforum_title'),
                'description' => $Request->get('subforum_description'),
                'keyword' => $Request->get('subforum_keyword')
            ]);

            return redirect()->route('category', [$category->keyword]);
        }
        return redirect()->back()->withErrors(['class' => 'warning', 'content' => 'Đã có một lỗi xảy ra. Mã lỗi: ' . $validator->errors()->first()]);
    }

    public function editSubforum (Request $Request)
    {
        $action = $Request->get('action');
        if ($action === 'edit')
        {
            $validator = Validator::make([
                'description' => $Request->get('description'),
                'keyword' => $Request->get('keyword'),
                'title'   => $Request->get('title'),
                'confirm' => $Request->get('confirm')
            ], [
                'description'   => ['required'],
                'keyword' => ['required', 'max:40', 'regex:/^[A-Za-z0-9-]+$/'],
                'title'   => ['required', 'max:40'],
                'confirm' => ['accepted']
            ]);
            if (!$validator->fails())
            {
                ForumCategories::updateCategory($Request->id, $Request);
                return redirect()->back()->withErrors(['class' => 'success', 'content' => 'Đã cập nhật thành công!']);
            }
            return redirect()->back()->withErrors(['class' => 'warning', 'content' => 'Đã có một lỗi xảy ra. Mã lỗi: ' . $validator->errors()->first()]);
        }
    }

    public function censorUser (Request $Request)
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
