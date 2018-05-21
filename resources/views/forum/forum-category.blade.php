@extends('templates.forum-template')
@section('title', $category_name)

@section('forum-content')
	<legend>các chủ đề trong {{ $category_name }}</legend>
	@section('breadcrumb_content')
		<li><a href="{{ route('forum') }}">forum</a></li>
		<li class="active">{{ $category_name }}</li>
	@endsection
	@if ($category_threads->total() > 0)
		@foreach ($category_threads as $post)
			@component('templates.media-template', [
				'url' => route('thread', ['thread_id' => $post->post_id]),
				'display_url' => $post->title,
				'display_small' => 'tạo bởi ' . App\User::username($post->user_id) . ' vào lúc ' . date_format($post->created_at, 'H:m:s A, d-m-Y')
			])
			@endcomponent
		@endforeach
		{{ $category_threads->links() }}
	@else
		là người đầu tiên tạo 1 chủ đề trong {{ $category_name }}
	@endif
@endsection

@section('create-post')
	@if (Auth::check())
		@include('forms.create-post-form', [
			'parent' => 0,
			'thread' => true
		])
	@else
		đăng nhập để tạo 1 chủ đề mới trong {{ $category_name }}
	@endif
@endsection
