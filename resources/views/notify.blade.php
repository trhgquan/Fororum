@extends('home')
@section('title', 'Notification')

@section('content')
    @if (!empty(App\UserNotification::count(Auth::id())))
        <p>You have {{ App\UserNotification::count(Auth::id()) }} notification:</p>
        @foreach (App\UserNotification::notify(Auth::id()) as $notify)
            <div class="media-box">
                <b><a href="{{ route('user.profile.username', ['autobot']) }}">autobot</a></b>
                <small>{{ date_format($notify->created_at, 'd-m-Y h:i:s A') }}</small>
                <p>{{ $notify->content }}</p>
                <a href="{{ route('notify.notifies', ['notify_id' => $notify->notify_id]) }}">find out more</a>
            </div>
        @endforeach
        {{ App\UserNotification::notify(Auth::id())->links() }}
    @else
        <div class="notify-title">
            <h1>You don't have anything new!</h1>
            <p>New notifications appears here.</p>
        </div>
    @endif
@endsection
