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
	<legend>Supreme Leader Control Panel {{ isset($action) ? ':: '.$action : '' }}</legend>
	<div class="row">
		<div class="col-md-2">
			@include('admin.elements.admin-sidebar')
		</div>
		<div class="col-md-10">
			@switch ($action)
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
	</div>
@endsection
