@extends('templates.app-template', [
	'navbar_brand' => 'for Webmaster',
])

@section('title', 'Dashboard')

@section('navbar_item')
	<li><a href="{{ url('/') }}">Home</a></li>
    @include('items.navbar-items')
@endsection

@section('content')
	@include('admin.elements.admin-navbar')
	@if ($errors->has('class'))
        @component('templates.alert-template', [
            'alert_title' => 'Notice',
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
			@if ($role === 'user')
				@include('admin.elements.manage.manage-user-reports', ['reports' => App\UserReport::getUsersOnly()])
			@else
				<div class="notify-title">
					<h1>Building in progress.</h1>
					<a href="https://github.com/trhgquan">DEVELOPER'S GITHUB</a>
				</div>
			@endif
			@break

		@case('editUser')
			@include('admin.elements.manage.manage-user-profiles')
			@break

		@default
			@include('admin.elements.admin-quick')
			@break
	@endswitch

	<legend>System information</legend>
	<p>
		Laravel version: {{ app()::VERSION }}<br/>
		PHP version: {{ phpversion() }}<br/>
		Database version: {{ (DB::connection()->getPdo())->query('select version()')->fetchColumn() }}
	</p>
@endsection
