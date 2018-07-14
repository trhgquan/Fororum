@extends('forum.forum-template')

@section('forum-content')
	<legend>Sảnh chính</legend>
	@foreach( $records as $categories )
		@component('forum.elements.category-template', [
			'media' => $categories
		])
		@endcomponent
	@endforeach
@endsection
