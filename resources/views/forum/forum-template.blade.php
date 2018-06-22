@extends('templates.app-template')

@section('title', 'Diễn đàn')

@section('navbar_brand')
	<a href="{{ route('forum') }}" class="navbar-brand">{{ config('app.name') }} <small>forum</small></a>
@endsection

@section('navbar_item')
	@if (Auth::check())
		@include('forms.search-navbar-form', ['action' => 'post'])
		@include('items.navbar-items')
	@else
		<li><a href="{{ route('login') }}">Đăng nhập</a></li>
		<li><a href="{{ route('register') }}">Đăng ký</a></li>
	@endif
@endsection

@section('content')
	@if ($errors->has('errors'))
		@component('templates.alert-template', [
			'alert_class' => 'danger',
			'alert_title' => 'Lỗi',
			'alert_content' => $errors->first('errors')
		])
		@endcomponent
	@endif
	@include('items.breadcrumb-items')
	@yield('forum-content')
	@yield('create-post')
@endsection
