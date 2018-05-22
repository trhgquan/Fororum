@extends('templates.forum.forum-template')

@section('forum-content')
	@section('breadcrumb_content')
		<li class="active">forum</li>
		<li></li>
	@endsection
	<legend>sảnh chính</legend>
	@foreach( $records as $categories )
		@component('templates.forum.category-template', [
			'media' => $categories
		])
		@endcomponent
	@endforeach
@endsection
