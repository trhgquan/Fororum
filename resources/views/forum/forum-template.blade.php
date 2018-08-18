@extends('templates.app-template', ['navbar_brand' => 'forum'])

@section('title', 'Forum')

@section('navbar_item')
	@if (Auth::check())
		@include('forms.search.search-navbar-form', ['action' => 'post'])
		@include('items.navbar-items')
	@else
		<li><a href="{{ route('auth.login') }}">Login</a></li>
		<li><a href="{{ route('auth.register') }}">Sign up</a></li>
	@endif
@endsection

@section('content')
	@if ($errors->has('errors'))
		@component('templates.alert-template', [
			'alert_class' => 'danger',
			'alert_title' => 'Error',
			'alert_content' => $errors->first('errors')
		])
		@endcomponent
	@endif
	@yield('forum-content')
	@yield('create-post')
@endsection
