@extends('templates.forum.forum-template')
@section('forum-content')
	@if (isset($thread) && $thread)
		@section('title', 'chủ đề: ' . $content['thread']->title)
		@section('breadcrumb_content')
			<li><a href="{{ route('forum') }}">forum</a></li>
			<li><a href="{{ route('category', ['category' => App\ForumCategories::Category($content['thread']->category_id)->keyword ]) }}">{{ App\ForumCategories::Category($content['thread']->category_id)->title }}</a></li>
			<li>{{ $content['thread']->title }}</li>
		@endsection
		@component('templates.forum.post-template',[
			'post' => $content['thread'],
			'single' => false
		])
		@endcomponent
		<legend>trả lời</legend>
		@if ($content['posts']->count() > 0)
			@foreach ($content['posts'] as $post)
				@component('templates.forum.post-template', [
					'post'   => $post,
					'parent' => $content['thread'],
					'single' => false
				])
				@endcomponent
			@endforeach
		@else
			trở thành người đầu tiên bình luận về {{ $content['thread']->title }}.
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
		@section('breadcrumb_content')
			<li><a href="{{ route('forum') }}">forum</a></li>
			<li><a href="{{ route('category', [
				'category' => App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->keyword])}}">{{ 	App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->title }}</a></li>
			<li><a href="{{ route('thread', ['thread_id' => !empty($content->parent_id) ? $content->parent_id : $content->post_id]) }}">{{ App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->title }}</a></li>
			<li class="active">{{ $content->title }}</li>
		@endsection

		@component('templates.forum.post-template', [
			'post'   => $content,
			'parent' => App\ForumPosts::thread($content->parent_id)['thread'],
			'single' => true
		])
		@endcomponent
	@endif
@endsection
