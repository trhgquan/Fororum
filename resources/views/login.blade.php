@extends('templates.app-template', ['meta' => [
	'keyword' => [config('app.name'),'login', 'dang-nhap'],
	'description' => 'Đăng nhập vào tài khoản ' . config('app.name'),
	'og:description' => 'Đăng nhập vào tài khoản ' . config('app.name')
]])

@section('title', 'Đăng nhập')

@section('navbar_item')
	<li><a href="{{ route('register') }}">Đăng ký</a></li>
@endsection

@section('content')
	@include('forms.login-form')
@endsection
