<?php

namespace App\Http\Controllers;

use App\User;
use App\UserBlacklists;
use App\UserReport;
use App\UserInformation;
use App\UserNotification;
use App\ForumCategories;
use App\ForumPosts;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    /**
     * create a subforum
     * @param  Illuminate\Http\Request $Request
     * @return null
     */
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
            'keyword' => ['required', 'unique:forum_categories,keyword', 'max:40', 'regex:/^[A-Za-z0-9](?!.*?[^\nA-Za-z0-9]{2}).*?[A-Za-z0-9]+$/'],
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

    /**
     * edit a subforum
     * @param  Illuminate\Http\Request $Request
     * @return null
     */
    public function editSubforum (Request $Request)
    {
        $action = $Request->get('action');
        if ($action === 'edit')
        {
            $validator = Validator::make([
                'description' => $Request->get('description'),
                'keyword' => $Request->get('keyword'),
                'title'   => $Request->get('title')
            ], [
                'description'   => ['required'],
                'keyword' => ['required', 'max:40', 'regex:/^[A-Za-z0-9](?!.*?[^\nA-Za-z0-9]{2}).*?[A-Za-z0-9]$/'],
                'title'   => ['required', 'max:40']
            ]);
            if (!$validator->fails())
            {
                ForumCategories::updateCategory($Request->id, $Request);
                return redirect()->back()->withErrors(['class' => 'success', 'content' => 'Đã cập nhật thành công!']);
            }
            return redirect()->back()->withErrors(['class' => 'warning', 'content' => 'Đã có một lỗi xảy ra. Mã lỗi: ' . $validator->errors()->first()]);
        }
        // basicly there are delete method.
        // but we will not build it here.
    }

    /**
     * edit user information
     * @param  Illuminate\Http\Request $Request
     * @return null
     */
    public function editUserInformation (Request $Request)
    {
        $validator = Validator::make([
            'username' => $Request->get('username'),
            'permissions' => $Request->get('permissions')
        ], [
            'username' => 'required',
            'permissions' => 'required'
        ]);

        if (!$validator->fails())
        {
            $this->adminUpdateUser($Request->all());
            return redirect()->back()->withErrors(['content' => 'Đã cập nhật thành công!', 'class' => 'success']);
        }
        return redirect()->back()->withErrors(['title' => 'Lỗi', 'content' => 'Có lỗi đã xảy ra. Mã lồi: ' . $validator->errors()->first(), 'class' => 'danger']);
    }

    /**
     * review user's report.
     * @param  Illuminate\Http\Request $Request
     * @return null
     */
    public function reviewUserReport (Request $Request)
    {
        $accepted = $Request->get('action');
        if ($this->accepted($accepted))
        {
            UserBlacklists::ban(UserReport::report_information($Request->get('rpid'))->participant_id, $Request->get('expire')); // ban the user
        }

        UserReport::review($Request->get('rpid'), $this->accepted($accepted, ['phê chuẩn', 'bác bỏ'])); // review the reports;

        return redirect()->back()->withErrors([
            'class' => $this->accepted($accepted, ['danger', 'info']),
            'content' => $this->accepted($accepted, [
                'Đã phê chuẩn báo cáo của người dùng thành công!',
                'Đã bác bỏ báo cáo của người dùng thành công!'
            ]),
        ]);
    }

    /**
     * this is just a procedure to update user informations.
     * instead create a bunch of spaghetti upthere
     * cut it into small methods in here.
     * @param  Array  $arrUser
     * @return null
     */
    protected function adminUpdateUser (Array $arrUser)
    {
        $this->updateProfile($arrUser);
        $this->updatePermissions($arrUser);
    }

    /**
     * update user profile
     * @param  Array  $array
     * @return null
     */
    protected function updateProfile (Array $data)
    {
        $user = User::find($data['id']);
        $user->username = $data['username'];
        $user->save();
    }

    /**
     * update user permissions
     * @param  Array  $array
     * @return null
     */
    protected function updatePermissions(Array $data)
    {
        $user = UserInformation::find($data['id']);
        $permissions = (int) $data['permissions'];
        if ($permissions > 2)
        {
            $user->permissions = $permissions;
        }
        else
        {
            $user->confirmed = (($permissions) ? 0 : 1);
            $user->permissions = ((!$permissions) ?: 1);
        }
        $user->save();
    }

    /**
     * this method checking the report
     * has been approved or rejected
     * @param  string $action
     * @param  array  $options event if success / failure nullable
     * @return boolean
     */
    protected function accepted ($action, Array $options = [])
    {
        if (!empty($options))
        {
            return ($action === 'accept') ? $options[0] : $options[1];
        }
        return ($action === 'accept');
    }
}
