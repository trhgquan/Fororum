@extends('templates.app-template')

@section('title', 'Đăng nhập')

@section('navbar_item')
	<li><a href="{{ route('register') }}">Đăng ký</a></li>
@endsection

@section('content')
	@include('forms.login-form')
@endsection
