@extends('forum.forum-template', ['meta' => [
	'description'    => 'Forum ' . config('app.name'),
	'og:description' => 'Forum ' . config('app.name')
]])

@section('forum-content')
	<legend>General</legend>
	@foreach( $records as $categories )
		@component('forum.elements.category-template', [
			'media' => $categories
		])
		@endcomponent
	@endforeach
@endsection
