<?php

namespace App\Http\Controllers;

use App\ForumPosts;
use App\User;
use App\Http\Controllers\Forum\CreatingPosts;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator;

class SearchController extends Controller
{
    use CreatingPosts;
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
            'keyword.required' => 'The keyword field is required.',
            'keyword.min'      => 'The keyword\'s minimum length is 3 characters.',
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
                if ($this->paginateCheck($results[$action])) {
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
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function searchWithKeyword(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'keyword' => ['required', 'min:3'], // keyword for post to, so get rid of the fakkin regex.
            'action'  => ['required', 'regex:/^[A-Za-z]+$/'],
        ], [
            'keyword.required' => 'The keyword field is required.',
            'keyword.min'      => 'The keyword\'s minimum length is 3 characters.',
            'action.regex'	    => 'An error occurred. Please try again.',
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
     * @param Illuminate\Http\Request $Request
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
            return redirect()->route('admin.profiles-manager.search.result', ['keyword' => $Request->get('keyword')]);
        }

        return redirect()->back()->withErrors($validator);
    }
}
