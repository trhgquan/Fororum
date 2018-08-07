<?php

namespace App\Http\Controllers;

use App\ForumPosts;
use App\User;
use Illuminate\Http\Request;
use Validator;

class SearchController extends Controller
{
    /**
     * user must logged in, and not a zombie.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'alive']);
    }

    /**
     * GET version, searching something.
     * there is a POST version below. But every search things
     * come back here.
     *
     * @param string $action  search for a post or a profile
     * @param string $keyword
     *
     * @return null
     */
    public function search($action, $keyword)
    {
        $validator = Validator::make([
            'keyword' => $keyword,
        ], [
            'keyword' => ['required', 'min:3'],
        ], [
            'keyword.required' => 'Từ khóa không được bỏ trống',
            'keyword.min'      => 'Từ khóa phải ít nhất 3 ký tự',
        ]);

        if (!$validator->fails()) {
            $user_results = User::search($keyword);
            $post_results = ForumPosts::search($keyword);
            $results = [
                'profile' => $user_results,
                'post'    => $post_results,
            ];
            $fillable = ['profile', 'post'];

            if (in_array($action, $fillable)) {
                if ($results[$action]->currentPage() <= $results[$action]->lastPage()) {
                    return view('search', [
                        'keyword'      => $keyword,
                        'have_results' => true,
                        'results'      => $results,
                        'action'       => $action,
                    ]);
                }

                return redirect()->route('search', [
                    'keyword' => $keyword, 'action' => $action,
                ]);
            }

            return redirect()->route('search.home');
        }

        return redirect()->route('search.home')->withErrors($validator);
    }

    /**
     * POST version for searching something.
     *
     * @param Request $Request
     *
     * @return null
     */
    public function searchWithKeyword(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'keyword' => ['required', 'min:3'], // keyword for post to, so get rid of the fakkin regex.
            'action'  => ['required', 'regex:/^[A-Za-z]+$/'],
        ], [
            'keyword.required' => 'Từ khóa không được bỏ trống.',
            'keyword.min'      => 'Từ khóa phải ít nhất 3 ký tự.',
            'action.regex'	    => 'Một lỗi không mong muốn vừa xảy ra.',
        ]);

        if (!$validator->fails()) {
            return redirect()->route('search', [
                'keyword' => $Request->get('keyword'),
                'action'  => $Request->get('action'),
            ]);
        }

        return redirect()->route('search.home')->withErrors($validator);
    }

    /**
     * search engine for admin panel
     * by redirect to the get route.
     *
     * @param Request $Request
     *
     * @return null
     */
    public function adminSearchEngine(Request $Request)
    {
        $validator = Validator::make([
            'keyword' => $Request->get('keyword'),
        ], [
            'keyword' => ['required'],
        ]);
        if (!$validator->fails()) {
            return redirect()->route('admin.edit.user.search.result', ['keyword' => $Request->get('keyword')]);
        }

        return redirect()->back()->withErrors($validator);
    }
}
