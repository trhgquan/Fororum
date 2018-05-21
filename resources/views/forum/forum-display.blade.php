@extends('templates.forum-template')
@section('forum-content')
	@if (isset($thread) && $thread)
		@section('title', 'chủ đề: ' . $content['thread']->title)
		@section('breadcrumb_content')
			<li><a href="{{ route('forum') }}">forum</a></li>
			<li><a href="{{ route('category', ['category' => App\ForumCategories::Category($content['thread']->category_id)->keyword ]) }}">{{ App\ForumCategories::Category($content['thread']->category_id)->title }}</a></li>
			<li>{{ $content['thread']->title }}</li>
		@endsection
		@component('templates.media-template', [
			'url' => route('post', ['post_id' => $content['thread']->post_id]),
			'display_url' => $content['thread']->title,
			'display_small' => 'tạo bởi ' . App\User::username($content['thread']->user_id) . ' vào lúc ' . date_format($content['thread']->created_at, 'H:m:s A, d-m-Y'),
			'display_content' => $content['thread']->content,
		])
		@endcomponent
		<legend>trả lời</legend>
		@if ($content['posts']->count() > 0)
			@foreach ($content['posts'] as $post)
				@component('templates.media-template', [
					'url' => route('post', ['post_id' => $post->post_id]),
					'display_url' => $post->title,
					'display_small' => 'đăng bởi ' . App\User::username($post->user_id) . ' vào lúc ' . date_format($post->created_at, 'H:m:s A, d-m-Y'),
					'display_content' => $post->content,
				])
				@endcomponent
			@endforeach
			{{ $content['posts']->links() }}
		@else
			trở thành người đầu tiên bình luận về chủ đề "{{ $content['thread']->title }}".
		@endif
		@section('create-post')
			@if (Auth::check())
				@include('forms.create-post-form', [
					'parent' => (isset($thread) && !empty($thread)) ? $content['thread']->post_id : 0,
					'thread' => false
				])
			@else
				đăng nhập để bình luận về chủ đề "{{ $content['thread']->title }}".
			@endif
		@endsection
	@else
		@section('title', 'bài viết: ' . $content->title)
		@section('breadcrumb_content')
			<li><a href="{{ route('forum') }}">forum</a></li>
			<li><a href="{{ route('category', [
				'category' => App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->keyword])}}">{{ 	App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->title }}</a></li>
			<li><a href="{{ route('thread', ['thread_id' => !empty($content->parent_id) ? $content->parent_id : $content->post_id]) }}">{{ App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->title }}</a></li>
			<li class="active">{{ $content->title }}</li>
		@endsection
		@component('templates.media-template', [
			'display_text' => $content->title,
			'display_small' => ' đăng bởi ' . App\User::username($content->user_id) . ' vào lúc ' . $content->created_at,
			'display_content' => $content->content,
		])
		@endcomponent
	@endif
@endsection
