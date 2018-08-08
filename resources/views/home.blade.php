@extends('templates.app-template', ['meta' => [
	'description' => config('app.name').' - Trang chủ',
	'keyword'     => config('app.name')
]])

@section('title', 'Trang chủ')

@if (!Auth::check())
	@section('navbar_item')
		<li><a href="{{ route('login') }}">Đăng nhập</a></li>
		<li><a href="{{ route('register') }}">Đăng ký</a></li>
	@endsection
@else
	@section('navbar_item')
		@include('items.navbar-items')
	@endsection
@endif

@section('content')
	<div class="jumbotron">
		@if (Auth::check())
			<h1>Chào {{ Auth::user()->username }}!</h1>
			<p>Cổng thông tin chính thức và diễn đàn của {{ config('app.name') }}</p>
			<a href="{{ route('forum') }}">forum</a>
			<a href="{{ route('search.home') }}">search</a>
			@if (App\UserInformation::userPermissions(Auth::id())['admin'])
				<a href="{{ route('admin.home') }}">admin</a>
			@endif
		@else
			<h1 class="page-title">{{ config('app.name') }}</h1>
			<p>Cổng thông tin chính thức, diễn đàn open-source của {{ config('app.name') }}</p>
			<p>Đã có <span id="realtime">0</span> người tham gia! <a href="{{ route('register') }}">Tham gia ngay!</a></p>
		@endif
	</div>
@endsection

@if (!Auth::check())
	@section('extrajs')
		<script src="{{ url('js/counter.js') }}"></script>
		<script type="text/javascript">counter({{ App\User::count() }}, 'realtime', 75)</script>
	@endsection
@endif
