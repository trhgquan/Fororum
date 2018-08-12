@extends('templates.app-template', ['meta' => [
	'keyword' => [config('app.name'),'login', 'sign-in'],
	'description' => 'Log in to ' . config('app.name'),
	'og:description' => 'Log in to ' . config('app.name')
]])

@section('title', 'Log into your account')

@section('navbar_item')
	<li><a href="{{ route('register') }}">Sign up</a></li>
@endsection

@section('content')
	@include('forms.login-form')
@endsection
