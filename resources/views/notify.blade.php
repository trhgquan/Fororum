@extends('home')
@section('title', 'Thông báo')

@section('content')
    @if (!empty(App\UserNotification::count(Auth::id())))
        <p>Bạn có {{ App\UserNotification::count(Auth::id()) }} thông báo mới:</p>
        @foreach (App\UserNotification::notify(Auth::id()) as $notify)
            <h3><a href="{{ route('notify.notifies', ['notify_id' => $notify->notify_id]) }}">{{ $notify->content }}</a></h3>
        @endforeach
        {{ App\UserNotification::notify(Auth::id())->links() }}
    @else
        <div class="notify-title">
            <h1>Bạn không có thông báo nào mới!</h1>
            <p>Nếu có thông báo mới, chúng sẽ xuất hiện ở đây.</p>
        </div>
    @endif
@endsection
