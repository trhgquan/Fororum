@extends('forum.forum-template', ['meta' => [
	'description' => (isset($thread) && $thread) ? $content['thread']->title : App\ForumPosts::postTitle($content->post_id)
]])
@section('forum-content')
	{{-- Display the thread with posts --}}
	@if (isset($thread) && $thread)
		@section('title', 'Thread: ' . $content['thread']->title)

		@component('items.breadcrumb-items', ['breadcrumb' => App\ForumPosts::breadcrumbs($content['thread']->post_id)])
		@endcomponent

		<legend>{{ $content['thread']->title }}</legend>

		@component('forum.elements.post-template',[
			'post' => $content['thread'],
			'single' => false
		])
		@endcomponent

		@if (App\ForumPosts::totalPosts($content['thread']->post_id) > 0)
			<legend>Replies</legend>

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
			<p>Be the first to post a reply to "{{ $content['thread']->title }}".</p>
		@endif

		@section('create-post')
			@if (Auth::check())
				@include('forms.create-post-form', [
					'parent' => (isset($thread) && !empty($thread)) ? $content['thread']->post_id : 0,
					'thread' => false
				])
			@else
				<p>Log in to post a reply to "{{ $content['thread']->title }}".</p>
			@endif
		@endsection
	@else
@section('title', 'Post: ' . App\ForumPosts::postTitle($content->post_id))

		@component('items.breadcrumb-items', ['breadcrumb' => App\ForumPosts::breadcrumbs($content->post_id)])
		@endcomponent

		<legend>Post:</legend>

		@component('forum.elements.post-template', [
			'post'   => $content,
			'parent' => (!empty(App\ForumPosts::post($content->post_id)->parent_id)) ? App\ForumPosts::thread(App\ForumPosts::post($content->post_id)->parent_id)['thread'] : App\ForumPosts::post($content->post_id),
			'single' => true
		])
		@endcomponent
	@endif
@endsection
