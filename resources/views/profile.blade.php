@extends('templates.app-template', ['navbar_brand' => 'profile'])

@if (!$edit)
	@section('title', $content['user_content']->username)
@else @section('title', 'Edit your profile')
@endif

@section('navbar_item')
	@if (!$edit)
		@include('forms.search.search-navbar-form', ['action' => 'profile'])
	@endif
	@include('items.navbar-items')
@endsection

@section('content')
	@if (!$edit)
		<div class="row">
			<div class="col-md-12">
				<legend>
					<h1>
						{{ $content['user_content']->username }}
						<small>
							@component('templates.badges-template', ['o' => App\UserInformation::userPermissions($content['user_content']->id)])
							@endcomponent
						</small>
					</h1>
				</legend>
			</div>
			<!-- 3 cột, cột đầu là forum statistics, cột sau là user information, cột cuối cùng là user action -->
			@if (!App\UserInformation::userPermissions($content['user_content']->id)['banned'])
				<div class="col-md-4">
					<p>Total threads created: <b>{{ $content['history']['threads']->count() }}</b></p>
					<p>Total posts created: <b>{{ $content['history']['posts']->count() }}</b></p>
				</div>

				<div class="col-md-4">
					<p>Email: <b>{{ $content['user_content']->email }}</b></p>
					<p>Joined {{ config('app.name') }} on <b>{{ date_format($content['user_content']->created_at, 'd-m-Y') }}</b>, <b>{{ App\ForumPosts::ago($content['user_content']->created_at) }}</b> days ago.</p>
					@if ($this_profile)
						<a href="{{ route('user.edit') }}">Edit your profile</a>
					@else
						@if (!App\UserReport::is_reported(Auth::id(), $content['user_content']->id, 'profile'))
							<a href="{{ route('report.profile', [$content['user_content']->username]) }}">Report {{ $content['user_content']->username }}</a>
						@else
							<div class="label label-danger">Reported</div>
						@endif
					@endif
				</div>

				<div class="col-md-4">
					<p><b><span id="1strealtime"></span></b> profiles following.</p>
					<p>following <b><span id="2ndrealtime"></span></b> profiles.</p>
					@include('forms.profile.follow-form')
				</div>

				@section('extrajs')
					<script src="{{ url('js/counter.js') }}"></script>
					<script type="text/javascript">
						counter({{ App\UserFollowers::followers($content['user_content']->id) }}, '1strealtime', 75)
						counter({{ App\UserFollowers::following($content['user_content']->id) }}, '2ndrealtime', 75)
					</script>
				@endsection
			@else
				<div class="col-md-12">
					<p>This account has been banned because of violation of the TERMS OF SERVICE. <a href="#">Find out more.</a></p>
				</div>
			@endif
		</div>
	@else
		@include('forms.profile.edit-profile-form')
	@endif
@endsection
