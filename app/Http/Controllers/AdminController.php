<?php

namespace App\Http\Controllers;

use App\ForumCategories;
use App\User;
use App\UserBlacklists;
use App\UserInformation;
use App\UserReport;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    /**
     * create a subforum.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function createSubforum(Request $Request)
    {
        $validator = Validator::make([
            'title'       => $Request->get('subforum_title'),
            'description' => $Request->get('subforum_description'),
            'keyword'     => $Request->get('subforum_keyword'),
            'confirm'     => $Request->get('confirm'),
        ], [
            'title'         => ['required', 'max:40'],
            'description'   => ['required', 'min:40'],
            'keyword'       => ['required', 'unique:forum_categories,keyword', 'max:40', 'regex:/^[A-Za-z0-9](?!.*?[^\nA-Za-z0-9]{2}).*?[A-Za-z0-9]+$/'],
            'confirm'       => ['accepted'],
        ]);
        if (!$validator->fails()) {
            $category = ForumCategories::create([
                'title'       => $Request->get('subforum_title'),
                'description' => $Request->get('subforum_description'),
                'keyword'     => $Request->get('subforum_keyword'),
            ]);

            return redirect()->route('category', [$category->keyword]);
        }

        return redirect()->back()->withErrors(['class' => 'warning', 'content' => 'An error occured. Code:  '.$validator->errors()->first()]);
    }

    /**
     * edit a subforum.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function editSubforum(Request $Request)
    {
        $action = $Request->get('action');
        if ($action === 'edit') {
            $validator = Validator::make([
                'description' => $Request->get('description'),
                'keyword'     => $Request->get('keyword'),
                'title'       => $Request->get('title'),
            ], [
                'description'   => ['required'],
                'keyword'       => ['required', 'max:40', 'regex:/^[a-z0-9]+(?:[.-][a-z0-9]+)*$/'],
                'title'         => ['required', 'max:40'],
            ]);
            if (!$validator->fails()) {
                ForumCategories::updateCategory($Request->id, $Request);

                return redirect()->back()->withErrors(['class' => 'success', 'content' => 'Subforum edited successfully.']);
            }

            return redirect()->back()->withErrors(['class' => 'warning', 'content' => 'An error occurred. Code:  '.$validator->errors()->first()]);
        }
        // basicly there are delete method.
        // but we will not build it here.
    }

    /**
     * edit user information.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function editUserInformation(Request $Request)
    {
        $validator = Validator::make([
            'username'    => $Request->get('username'),
            'permissions' => $Request->get('permissions'),
        ], [
            'username'    => 'required',
            'permissions' => 'required',
        ]);

        if (!$validator->fails()) {
            $this->adminUpdateUser($Request->all());

            return redirect()->back()->withErrors(['content' => 'Account #'.$Request->get('id').' edited successfully', 'class' => 'success']);
        }

        return redirect()->back()->withErrors(['title' => 'Error', 'content' => 'An error occurred. Code:  '.$validator->errors()->first(), 'class' => 'danger']);
    }

    /**
     * review user's report.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function reviewUserReport(Request $Request)
    {
        $accepted = $Request->get('action');
        if ($this->accepted($accepted)) {
            UserBlacklists::ban(UserReport::report_information($Request->get('rpid'))->participant_id, $this->admin(), $Request->get('expire')); // ban the user
        }

        UserReport::review($Request->get('rpid'), $this->accepted($accepted, ['accepted', 'rejected'])); // review the reports;

        return redirect()->back()->withErrors([
            'class'   => $this->accepted($accepted, ['danger', 'info']),
            'content' => $this->accepted($accepted, [
                'User reports accepted.',
                'User reports rejected.',
            ]),
        ]);
    }

    /**
     * this is just a procedure to update user informations.
     * instead create a bunch of spaghetti upthere
     * cut it into small methods in here.
     *
     * @param array $arrUser
     *
     * @return null
     */
    protected function adminUpdateUser(array $arrUser)
    {
        $this->updateProfile($arrUser);
        $this->updatePermissions($arrUser);
    }

    /**
     * update user profile.
     *
     * @param array $array
     *
     * @return null
     */
    protected function updateProfile(array $data)
    {
        $user = User::find($data['id']);
        $user->username = $data['username'];
        $user->save();
    }

    /**
     * update user permissions.
     *
     * @param array $array
     *
     * @return null
     */
    protected function updatePermissions(array $data)
    {
        $user = UserInformation::find($data['id']);
        $permissions = (int) $data['permissions'];
        if ($permissions > 2) {
            $user->permissions = 3; // 3 is the moderator
        } else {
            $user->confirmed = (($permissions === 2) ? 1 : 0);
            $user->permissions = (($permissions === 2) ?: 1);
        }
        $user->save();
    }

    /**
     * this method checking the report
     * has been approved or rejected.
     *
     * @param string $action
     * @param array  $options event if success / failure nullable
     *
     * @return mixed
     */
    protected function accepted($action, array $options = [])
    {
        if (!empty($options)) {
            return ($action === 'accept') ? $options[0] : $options[1];
        }

        return $action === 'accept';
    }

    /**
     * method admin, return the admin id.
     *
     * @return int
     */
    protected function admin()
    {
        return auth()->id();
    }
}
