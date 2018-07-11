@extends('home')
@section('title', 'Thông báo')

@section('content')
    @if (!empty(App\UserNotification::count(Auth::id())))
        <p>Bạn có {{ App\UserNotification::count(Auth::id()) }} thông báo mới:</p>
        @foreach (App\UserNotification::notify(Auth::id()) as $notify)
            <div class="media-box">
                <b><a href="{{ route('user.profile.username', ['autobot']) }}">autobot</a></b>
                <small>{{ date_format($notify->created_at, 'd-m-Y h:i:s A') }}</small>
                <p>{{ $notify->content }}</p>
                <a href="{{ route('notify.notifies', ['notify_id' => $notify->notify_id]) }}">xem thêm</a>
            </div>
        @endforeach
        {{ App\UserNotification::notify(Auth::id())->links() }}
    @else
        <div class="notify-title">
            <h1>Bạn không có thông báo nào mới!</h1>
            <p>Nếu có thông báo mới, chúng sẽ xuất hiện ở đây.</p>
        </div>
    @endif
@endsection
