@extends('templates.app-template')

@section('title', (isset($keyword)) ? 'Kết quả tìm kiếm cho ' . $keyword : 'Tìm kiếm')

@section('navbar_brand')
	<a href="{{ url('/') }}" class="navbar-brand">{{ config('app.name') }} <small>search</small></a>
@endsection

@section('navbar_item')
    @include('items.navbar-items')
@endsection

@section('content')
    <div class="row">
        @if ($have_results)
            <div class="col-md-2">
                @include('items.search-sidebar-items')
            </div>

            <div class="col-md-10">
                @if ($results[$action]->total() > 0)
					@component('templates.alert-template', [
						'alert_class' => 'info',
						'alert_title' => 'Mẹo',
						'alert_content' => 'Hãy thay đổi từ khóa để có được kết quả đúng nhất hoặc có nhiều kết quả hơn.'
					])
					@endcomponent

                    @foreach ($results[$action] as $result)
                        @if ($action == 'profile')
                            <h3>
								<a href="{{ route('user.profile.username', [$result->username]) }}">{{ $result->username }}</a>
								<small>
									@component('templates.badges-template', ['o' => App\UserInformation::userPermissions($result->id)])
									@endcomponent
								</small>
							</h3>
                        @else
            				@component('forum.elements.post-template', ['post' => $result, 'single' => false])
                			@endcomponent
                        @endif
                    @endforeach
                    {{ $results[$action]->links() }}
                @else
                    <div class="notify-title">
                        <h1>không có kết quả cho từ khóa "{{ $keyword }}".</h1>
						<p>hãy chắc chắn rằng từ khóa của bạn chính xác, sau đó hãy thử lại</p>
                    </div>
                @endif
            </div>
        @else
            @include('forms.search-form')
        @endif
    </div>
@endsection
