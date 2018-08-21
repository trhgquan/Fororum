@extends('templates.app-template', ['meta' => [
	'keyword' => [config('app.name'),'register', 'sign-up'],
	'description' => 'Register an ' . config('app.name') . ' account',
	'og:description' => 'Register an ' . config('app.name') . ' account'
]])

@section('title', 'Register a new account')

@section('navbar_item')
	<li><a href="{{ route('auth.login') }}">Login</a></li>
@endsection

@section('content')
	@include('forms.auth.register-form')
@endsection
