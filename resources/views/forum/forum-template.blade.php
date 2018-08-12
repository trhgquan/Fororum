@extends('templates.app-template')

@section('title', 'Forum')

@section('navbar_brand')
	<a href="{{ route('forum') }}" class="navbar-brand">{{ config('app.name') }} <small>forum</small></a>
@endsection

@section('navbar_item')
	@if (Auth::check())
		@include('forms.search-navbar-form', ['action' => 'post'])
		@include('items.navbar-items')
	@else
		<li><a href="{{ route('login') }}">Login</a></li>
		<li><a href="{{ route('register') }}">Sign up</a></li>
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
