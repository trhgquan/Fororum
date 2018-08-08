@extends('templates.app-template', ['meta' => [
	'keyword' => [config('app.name'),'register', 'dang-ky'],
	'description' => 'Đăng ký một tài khoản ' . config('app.name'),
	'og:description' => 'Đăng ký một tài khoản ' . config('app.name')
]])

@section('title', 'Đăng ký')

@section('navbar_item')
	<li><a href="{{ route('login') }}">Đăng nhập</a></li>
@endsection

@section('content')
	@include('forms.register-form')
@endsection
