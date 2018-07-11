@extends('forum.forum-template')

@section('forum-content')
	@section('breadcrumb_content')
		<li class="active">forum</li>
		<li></li>
	@endsection
	<legend>Sảnh chính</legend>
	@foreach( $records as $categories )
		@component('forum.elements.category-template', [
			'media' => $categories
		])
		@endcomponent
	@endforeach
@endsection
