@extends('templates.app-template')

@section('title', 'Trang quản trị viên')

@section('navbar_brand')
	<a href="{{ route('admin.index') }}" class="navbar-brand">{{ config('app.name') }} <small>for Supreme Leader</small></a>
@endsection

@section('navbar_item')
	<li><a href="{{ url('/') }}">Trang chủ</a></li>
    @include('items.navbar-items')
@endsection

@section('content')
	@include('admin.elements.admin-navbar')
	<div class="row">
		@switch ($action)
			@case('dashboard')
				@break;

			@case('report')
				@include('admin.elements.admin-report', ['reports' => App\UserReport::getAll()])
				@break

			@case('staff')
				chưa build.
				@break

			@default
				@include('admin.elements.admin-quick')
				@break
		@endswitch
	</div>
@endsection
