@extends('templates.forum-template')

@section('forum-content')
	@section('breadcrumb_content')
		<li class="active">forum</li>
		<li></li>
	@endsection
	<legend>sảnh chính</legend>
	@foreach( $records as $categories )
		@component('templates.media-template', [
			'url' => route('category', [$categories->keyword]),
			'display_url' =>  $categories->title,
			'display_content' => $categories->description])
		@endcomponent
	@endforeach
@endsection
