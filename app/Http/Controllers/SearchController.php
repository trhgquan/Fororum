<?php

namespace App\Http\Controllers;

use App\User;
use App\ForumPosts;
use Illuminate\Http\Request;
use Validator;

class SearchController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'alive']);
	}

	public function search ($action, $keyword)
	{
		$validator = Validator::make([
			'keyword' => $keyword
		], [
			'keyword' => ['required', 'regex:/^[A-Za-z0-9._]+$/', 'min:3']
		], [
			'keyword.required' => 'Từ khóa không được bỏ trống',
			'keyword.min'      => 'Từ khóa phải ít nhất 3 ký tự',
			'keyword.regex'    => 'Từ khóa không hợp lệ'
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
				if ($results[$action]->currentPage() <= $results[$action]->lastPage())
				{
					return view('search', [
						'keyword'      => $keyword,
						'have_results' => true,
						'results'      => $results,
						'action'       => $action
					]);
				}
				return redirect()->route('search.home', [
					'keyword' => $keyword, 'action' => $action
				]);
			}
			return redirect()->route('search.home');
		}
	 	return redirect()->route('search.home')->withErrors($validator);
	}

	public function searchWithKeyword (Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'keyword' => ['required', 'regex:/^[A-Za-z0-9._]+$/', 'min:3'],
			'action'  => ['required', 'regex:/^[A-Za-z]+$/']
		], [
			'keyword.required' => 'Từ khóa không được bỏ trống.',
			'keyword.min'      => 'Từ khóa phải ít nhất 3 ký tự.',
			'keyword.regex'    => 'Từ khóa không hợp lệ.',
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
}
