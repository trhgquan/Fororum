<?php

namespace App\Http\Controllers;

use App\ForumCategories;
use App\ForumPosts;
use App\User;
use Auth;
use Validator;
use Illuminate\Http\Request;


class ForumController extends Controller
{
	public function __construct()
	{
		$this->middleware('alive');
	}

	public function home ()
	{
		return view('forum.forum-home', [
			'records' => ForumCategories::ForumCategories()
		]);
	}

	public function category ($category)
	{
		if (ForumCategories::CategoryExist($category))
		{
			$categoryObj = ForumCategories::Category($category);
			return view('forum.forum-category', [
				'category_name'    => $categoryObj->title,
				'category_id'      => $categoryObj->id,
				'category_threads' => ForumPosts::threads($categoryObj->id)
			]);
		}
		return abort(404);
	}

	public function thread ($thread_id)
	{
		return view('forum.forum-display', [
			'thread'  => true,
			'content' => ForumPosts::thread($thread_id)
		]);
	}

	public function post ($post_id)
	{
		return view('forum.forum-display', [
			'thread'  => false,
			'content' => ForumPosts::post($post_id)
		]);
	}

	public function createPost (Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'content' => 'required|min:50|max:255',
		], [
			'content.required' => 'Không được bỏ trống ô nội dung',
			'content.max'      => 'nội dung vượt quá độ dài cho phép',
			'content.min'	   => 'nội dung quá ngắn',
		]);

		if (!$validator->fails())
		{
			$parent = $Request->get('parent');
			if (!empty($parent) && empty(ForumPosts::post($parent)->parent_id)) // parent phải là 1 thread, mà thread thì parent_id = 0
			{
				$parent = ForumPosts::post($parent);
				$post   = ForumPosts::create([
					'parent_id' => $parent->post_id,
					'user_id'   => Auth::id(),
					'content'   => $Request->get('content')
				]);
				return redirect()->route('post', [$post->id]); // ở đây id là primary key của table.
			}
			return redirect()->back()->withErrors(['errors' => 'Không tìm thấy chủ đề!']);
		}
		return redirect()->back()->withErrors($validator)->withInput();
	}

	public function createThread (Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'title'   => 'required|min:50|max:70',
			'content' => 'required|min:50|max:255'
		], [
			'title.required'   => 'không thể để trống tiêu đề',
			'title.max'        => 'tiêu đề quá dài',
			'title.min'		   => 'tiêu đề quá ngắn',
			'content.required' => 'không thể để trống nội dung',
			'content.max'      => 'nội dung quá dài',
			'content.min'	   => 'nội dung quá ngắn'
		]);

		if (!$validator->fails() && ForumCategories::CategoryExist($Request->get('category'))) // subforum phải tồn tại
		{
			$thread = ForumPosts::create([
				'category_id' => $Request->get('category'),
				'user_id'     => Auth::id(),
				'title'       => $Request->get('title'),
				'content'     => $Request->get('content')
			]);
			return redirect()->route('thread', [$thread->id]); // tương tự: id là primary key của table
		}
		return redirect()->back()->withErrors($validator)->withInput();
	}
}
