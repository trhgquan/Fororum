@extends('forum.forum-template', ['meta' => [
	'description' => config('app.name') . ' - ' . $category_name,
	'keyword'     => [config('app.name'),$category_keyword]
]])
@section('title', $category_name)

@section('forum-content')
	@component('items.breadcrumb-items', ['breadcrumb' => App\ForumCategories::breadcrumbs($category_id)])
	@endcomponent
	<legend>Các chủ đề trong {{ $category_name }}</legend>
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
