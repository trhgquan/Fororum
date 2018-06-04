@extends('home')
@section('title', 'Thông báo')

@section('content')
    @if (!empty(App\UserNotification::count(Auth::id())))
        <p>bạn có {{ App\UserNotification::count(Auth::id()) }} thông báo mới:</p>
        @foreach (App\UserNotification::notify(Auth::id()) as $notify)
            <h3>
                <a href="{{ route('notify', ['notify_id' => $notify->notify_id]) }}"><b>{{ $notify->content }}</b></a>
            </h3>
        @endforeach
        {{ App\UserNotification::notify(Auth::id())->links() }}
    @else
        bạn không có thông báo nào mới!
    @endif
@endsection
