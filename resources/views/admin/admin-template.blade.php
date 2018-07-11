@extends('templates.app-template')

@section('title', 'Quản trị')

@section('navbar_brand')
	<a href="{{ route('admin.index') }}" class="navbar-brand">{{ config('app.name') }} <small>for Supreme Leader</small></a>
@endsection

@section('navbar_item')
	<li><a href="{{ url('/') }}">Trang chủ</a></li>
    @include('items.navbar-items')
@endsection

@section('content')
	@include('admin.elements.admin-navbar')
	@if ($errors->has('class'))
        @component('templates.alert-template', [
            'alert_title' => 'Thông báo',
            'alert_class' => $errors->first('class'),
            'alert_content' => $errors->first('content')
        ])
        @endcomponent
    @endif
	@switch ($action)
		@case('subforum')
			@include('admin.elements.admin-subforum', ['subforums' => App\ForumCategories::paginatedForumCategories()])
			@break

		@case('management')
			@include('admin.elements.admin-management', ['role' => $role])
			@break

		@default
			@include('admin.elements.admin-quick')
			@break
	@endswitch
@endsection
