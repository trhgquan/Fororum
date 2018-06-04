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
		$this->middleware('auth');
		$this->middleware('alive');
	}

	public function index()
	{
		return view('search');
	}

	public function searchForUser ($keyword)
	{
		$validator = Validator::make([
			'keyword' => $keyword
		], [
			'keyword' => ['required','regex:/^[A-Za-z0-9._]+$/','min:3']
		], [
			'keyword.required' => 'từ khoá không được bỏ trống',
			'keyword.min'         => 'từ khoá phải dài ít nhất 3 ký tự',
			'keyword.regex'      => 'từ khoá không hợp lệ'
		]);
		if (!$validator->fails())
		{
			$users = User::search($keyword);
			if ($users->currentPage() <= $users->lastPage())
			{
				return view('search', ['users' => $users,'keyword' => $keyword]);
			}
			return redirect()->route('searchForUser', [$keyword]);
		}
		return view('search',['keyword' => $keyword,'users' => 0])->withErrors($validator);
	}

	public function searchForPost ($keyword)
	{
		$validator = Validator::make(['keyword' => $keyword], [
			'keyword' => ['required','min:3','regex:/^[A-Za-z0-9]+$/']
		], [
			'keyword.min' => 'từ khoá phải dài ít nhất 3 ký tự',
			'keyword.required' => 'bạn phải nhập từ khoá tìm kiếm',
			'keyword.regex' => 'từ khoá không hợp lệ'
		]);
		if (!$validator->fails())
		{
			$posts = ForumPosts::search($keyword);
			if ($posts->currentPage() <= $posts->lastPage())
			{
				return view('search',['posts' => ForumPosts::search($keyword),'keyword' => $keyword]);
			}
			return redirect()->route('searchPostWithKeyword', [$keyword]);
		}
		return view('search', ['keyword' => $keyword,'posts' => 0])->withErrors($validator);
	}
}
