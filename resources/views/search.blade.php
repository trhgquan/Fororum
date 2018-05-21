@extends('templates.app-template')

@section('title', (isset($keyword)) ? 'Kết quả tìm kiếm cho ' . $keyword : 'Tìm kiếm')
@section('extracss')
	h3 > small
	{
		font-style: italic;
	}
@endsection

@section('navbar-brand')
	<a href="{{ url('/') }}" class="navbar-brand">{{ config('app.name') }} <small>search</small></a>
@endsection

@section('navbar_item')
	@if (isset($users))
		@include('forms.search-profile-form')
	@elseif (isset($posts))
		@include('forms.search-forum-form')
	@endif
	@include('items.dropdown-items')
@endsection

@section('content')
	@if ($errors->has('keyword'))
		{{ $errors->first('keyword') }}
	@endif
	@if (isset($users) && !empty($users) && !$errors->has('keyword'))
		<p>Bạn đã tìm kiếm <b>{{ $keyword }}</b> và có <b>{{ $users->total() }}</b> người được tìm thấy.</p>

		@if ($users->total() > 0)
			@foreach ($users as $user)
				<h3><a href="{{ route('profile', [$user->username]) }}">{{ $user->username }}</a> <small>{{ App\UserInformation::userBrandLevels($user->id) }}</small></h3>
			@endforeach
			@if ($users->total() > 1)
				{{ $users->links() }}
			@endif
		@endif
	@elseif (isset($posts) && !empty($posts) && !$errors->has('keyword'))
		<p>Bạn đã tìm kiếm <b>{{ $keyword }}</b> và có <b>{{ $posts->total() }}</b> post được tìm thấy.</p>
		@if ($posts->total() > 0)
			@foreach ($posts as $post)
				@component('templates.media-template', [
					'url' => route('post', ['id' => $post->post_id]),
					'display_url' => $post->title,
					'display_small' => 'đăng bởi ' . App\User::username($post->user_id) . ' vào lúc ' . date_format($post->created_at, 'H:m:s A, d-m-Y'),
				])
				@endcomponent
			@endforeach
			@if ($posts->total() > 1)
				{{ $posts->links() }}
			@endif
		@endif
	@else
		<h3 class="page-title">
			tìm kiếm một
			@if (isset($users))
				ai đó
			@elseif (isset($posts))
				chủ đề / bài viết
			@endif
		</h3>
	@endif
@endsection
