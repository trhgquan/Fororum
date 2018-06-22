@extends('forum.forum-template')
@section('forum-content')
	@if (isset($thread) && $thread)
		@section('title', 'chủ đề: ' . $content['thread']->title)
		@section('breadcrumb_content')
			<li><a href="{{ route('forum') }}">forum</a></li>
			<li><a href="{{ route('category', ['category' => App\ForumCategories::Category($content['thread']->category_id)->keyword ]) }}">{{ App\ForumCategories::Category($content['thread']->category_id)->title }}</a></li>
			<li>{{ $content['thread']->title }}</li>
		@endsection
		<legend>Chủ đề: {{ $content['thread']->title }}</legend>
		@component('forum.elements.post-template',[
			'post' => $content['thread'],
			'single' => false
		])
		@endcomponent
		@if (App\ForumPosts::totalPosts($content['thread']->post_id) > 0)
			<legend>{{ App\ForumPosts::totalPosts($content['thread']->post_id) }} bài viết trả lời:</legend>
			@foreach ($content['posts'] as $post)
				@component('forum.elements.post-template', [
					'post'   => $post,
					'parent' => $content['thread'],
					'single' => false
				])
				@endcomponent
			@endforeach
			{{ $content['posts']->links() }}
		@else
			Trở thành người đầu tiên bình luận về {{ $content['thread']->title }}.
		@endif
		@section('create-post')
			@if (Auth::check())
				@include('forms.create-post-form', [
					'parent' => (isset($thread) && !empty($thread)) ? $content['thread']->post_id : 0,
					'thread' => false
				])
			@else
				Đăng nhập để bình luận về chủ đề "{{ $content['thread']->title }}".
			@endif
		@endsection
	@else
		@section('title', 'bài viết: ' . App\ForumPosts::postTitle($content->post_id))
		@section('breadcrumb_content')
			<li><a href="{{ route('forum') }}">forum</a></li>
			<li><a href="{{ route('category', ['category' => App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->keyword])}}">{{ App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->title }}</a></li>
			<li><a href="{{ route('thread', ['thread_id' => !empty($content->parent_id) ? $content->parent_id : $content->post_id]) }}">{{ (!empty($content->parent_id)) ? App\ForumPosts::postTitle($content->parent_id) : App\ForumPosts::postTitle($content->post_id) }}</a></li>
			<li class="active">{{ App\ForumPosts::postTitle($content->post_id) }}</li>
		@endsection
		<legend>Bài viết:</legend>
		@component('forum.elements.post-template', [
			'post'   => $content,
			'parent' => (!empty(App\ForumPosts::post($content->post_id)->parent_id)) ? App\ForumPosts::thread(App\ForumPosts::post($content->post_id)->parent_id)['thread'] : App\ForumPosts::post($content->post_id),
			'single' => true
		])
		@endcomponent
	@endif
@endsection
