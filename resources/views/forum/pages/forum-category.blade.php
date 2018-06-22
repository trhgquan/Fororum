@extends('forum.forum-template')
@section('title', $category_name)

@section('forum-content')
	<legend>Các chủ đề trong {{ $category_name }}</legend>
	@section('breadcrumb_content')
		<li><a href="{{ route('forum') }}">forum</a></li>
		<li class="active">{{ $category_name }}</li>
	@endsection
	@if ($category_threads->total() > 0)
		@foreach ($category_threads as $post)
			@component('forum.elements.thread-template', ['thread' => $post])
			@endcomponent
		@endforeach
		{{ $category_threads->links() }}
	@else
		Trở thành người đầu tiên tạo 1 chủ đề trong {{ $category_name }}
	@endif
@endsection

@section('create-post')
	@if (Auth::check())
		@include('forms.create-post-form', [
			'parent' => 0,
			'thread' => true
		])
	@else
		Đăng nhập để tạo 1 chủ đề mới trong {{ $category_name }}
	@endif
@endsection
