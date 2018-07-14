@extends('templates.app-template')

@if (!$edit)
	@section('title', $content['user_content']->username)
@else @section('title', 'Chỉnh sửa người dùng')
@endif

@section('navbar_item')
	@if (!$edit)
		@include('forms.search-navbar-form', ['action' => 'profile'])
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
					<p>Tổng số chủ đề đã tạo: <b>{{ $content['history']['threads']->count() }}</b></p>
					<p>Tổng số bài đăng trên diễn đàn: <b>{{ $content['history']['posts']->count() }}</b></p>
				</div>

				<div class="col-md-4">
					<p>Email liên hệ: <b>{{ $content['user_content']->email }}</b></p>
					<p>Tham gia vào ngày <b>{{ date_format($content['user_content']->created_at, 'd-m-Y') }}</b>, <b>{{ App\ForumPosts::ago($content['user_content']->created_at) }}</b> ngày trước.</p>
					@if ($this_profile)
						<a href="{{ route('user.edit') }}">đến trang chỉnh sửa hồ sơ</a>
					@else
						@if (!App\UserReport::is_reported(Auth::id(), $content['user_content']->id, 'profile'))
							<a href="{{ route('report.profile', [$content['user_content']->username]) }}">báo cáo {{ $content['user_content']->username }}</a>
						@else
							<div class="label label-danger">đã báo cáo</div>
						@endif
					@endif
				</div>

				<div class="col-md-4">
					<p>đã được <b><span id="1strealtime"></span></b> tài khoản đăng ký.</p>
					<p>đã đăng ký <b><span id="2ndrealtime"></span></b> tài khoản.</p>
					@include('forms.follow-form')
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
					<p>Tài khoản này đã bị khóa do vi phạm. <a href="#">Tìm hiểu thêm.</a></p>
				</div>
			@endif
		</div>
	@else
		@include('forms.edit-profile-form')
	@endif
@endsection
