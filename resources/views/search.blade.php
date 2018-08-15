@extends('templates.app-template', ['navbar_brand' => 'search'])

@section('title', (isset($keyword)) ? 'Search results for ' . $keyword : 'Search')

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
						'alert_title' => 'Tips',
						'alert_content' => 'Change the keyword to get the correct result or get more results.'
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
                        <h1>No results for "{{ $keyword }}".</h1>
						<p>Check the keyword again, make sure it's correct and then try again.</p>
                    </div>
                @endif
            </div>
        @else
            @include('forms.search.search-form')
        @endif
    </div>
@endsection
