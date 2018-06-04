@extends('templates.app-template')

@section('title', 'Đăng ký')

@section('navbar_item')
	<li><a href="{{ route('login') }}">Đăng nhập</a></li>
@endsection

@section('content')
	@include('forms.register-form')
@endsection