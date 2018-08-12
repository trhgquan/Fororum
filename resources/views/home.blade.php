@extends('templates.app-template', ['meta' => [
	'description' => config('app.name').' - Home',
	'keyword'     => config('app.name')
]])

@section('title', 'Home')

@if (!Auth::check())
	@section('navbar_item')
		<li><a href="{{ route('login') }}">Login</a></li>
		<li><a href="{{ route('register') }}">Sign up</a></li>
	@endsection
@else
	@section('navbar_item')
		@include('items.navbar-items')
	@endsection
@endif

@section('content')
	<div class="jumbotron">
		@if (Auth::check())
			<h1>Howdy, {{ Auth::user()->username }}.</h1>
			<p>Welcome back to {{ config('app.name') }}!</p>
			<a href="{{ route('forum') }}">forum</a>
			<a href="{{ route('search.home') }}">search</a>
			@if (App\UserInformation::userPermissions(Auth::id())['admin'])
				<a href="{{ route('admin.home') }}">admin</a>
			@endif
		@else
			<h1 class="page-title">{{ config('app.name') }}</h1>
			<p>Forum creavit cum Laravel.</p>
			<p><span id="realtime">0</span> user joined! <a href="{{ route('register') }}">Join us for free now.</a></p>
		@endif
	</div>
@endsection

@if (!Auth::check())
	@section('extrajs')
		<script src="{{ url('js/counter.js') }}"></script>
		<script type="text/javascript">counter({{ App\User::count() }}, 'realtime', 75)</script>
	@endsection
@endif
