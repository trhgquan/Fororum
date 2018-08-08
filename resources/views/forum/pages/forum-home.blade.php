@extends('forum.forum-template', ['meta' => [
	'description'    => 'Dien dan ' . config('app.name'),
	'og:description' => 'Dien dan ' . config('app.name')
]])

@section('forum-content')
	<legend>Sảnh chính</legend>
	@foreach( $records as $categories )
		@component('forum.elements.category-template', [
			'media' => $categories
		])
		@endcomponent
	@endforeach
@endsection
