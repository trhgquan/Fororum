<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInformation;
use App\ForumPosts;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
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
	 * @param  string $action  search for a post or a profile
	 * @param  string $keyword
	 * @return null
	 */
	public function search ($action, $keyword)
	{
		$validator = Validator::make([
			'keyword' => $keyword
		], [
			'keyword' => ['required', 'min:3']
		], [
			'keyword.required' => 'Từ khóa không được bỏ trống',
			'keyword.min'      => 'Từ khóa phải ít nhất 3 ký tự',
		]);

		if (!$validator->fails())
		{
			$user_results = User::search($keyword);
			$post_results = ForumPosts::search($keyword);
			$results = [
				'profile' => $user_results,
				'post' => $post_results
			];
			$fillable = ['profile', 'post'];

			if (in_array($action, $fillable))
			{
				if ($this->paginateCheck($results[$action]))
				{
					return view('search', [
						'keyword'      => $keyword,
						'have_results' => true,
						'results'      => $results,
						'action'       => $action
					]);
				}
				return redirect()->route('search', [
					'keyword' => $keyword, 'action' => $action
				]);
			}
			return redirect()->route('search.home');
		}
	 	return redirect()->route('search.home')->withErrors($validator);
	}

	/**
	 * POST version for searching something
	 * @param  Illuminate\Http\Request $Request
	 * @return null
	 */
	public function searchWithKeyword (Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'keyword' => ['required', 'min:3'], // keyword for post to, so get rid of the fakkin regex.
			'action'  => ['required', 'regex:/^[A-Za-z]+$/']
		], [
			'keyword.required' => 'Từ khóa không được bỏ trống.',
			'keyword.min'      => 'Từ khóa phải ít nhất 3 ký tự.',
			'action.regex'	   => 'Một lỗi không mong muốn vừa xảy ra.'
		]);

		if (!$validator->fails())
		{
			return redirect()->route('search', [
				'keyword' => $Request->get('keyword'),
				'action'  => $Request->get('action')
			]);
		}
		return redirect()->route('search.home')->withErrors($validator);
	}

	/**
	 * search engine for admin panel
	 * by redirect to the get route.
	 * @param  Illuminate\Http\Request $Request
	 * @return null
	 */
	public function adminSearchEngine (Request $Request)
	{
		$validator = Validator::make([
			'keyword' => $Request->get('keyword')
		], [
			'keyword' => ['required']
		]);
		if (!$validator->fails())
		{
			return redirect()->route('admin.edit.user.search.result', ['keyword' => $Request->get('keyword')]);
		}
		return redirect()->back()->withErrors($validator);
	}

	/**
	 * method paginateCheck
	 * check if this page is not the infinitive non-exist page.
	 * @param  Illuminate\Pagination\LengthAwarePaginator $object
	 * @return boolean
	 */
	protected function paginateCheck (Paginator $object)
	{
		return ($object->currentPage() <= $object->lastPage());
	}
}
