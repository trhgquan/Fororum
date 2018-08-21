@extends('home')
@section('title', 'Notification')

@section('content')
    @if (!empty($user->notifications->count()))
        <p>
            You have {{ $user->unreadNotifications->count() }} unread notification:
            @if (!empty($user->unreadNotifications->count()))
                <a href="{{ route('notify.read.all') }}" class="pull-right">mark all as read</a>
            @endif
            <a href="{{ route('notify.delete.all') }}" class="pull-right">delete all</a>
        </p>

        @foreach ($user->notifications as $notify)
            <div class="media-box">
                <b><a href="{{ route('profile.user', [$notify['data']['from']]) }}">{{ $notify['data']['from'] }}</a></b>
                <small>{{ date_format($notify->created_at, 'd-m-Y h:i:s A') }}</small>
                @if (empty($notify['read_at']))
                    <span class="label label-danger">new</span>
                @endif
                <p>{{ $notify['data']['content'] }}</p>
                <a href="{{ route($notify['data']['route'], [$notify['data']['param']]) }}">find out more</a>
            </div>
        @endforeach
    @else
        <div class="notify-title">
            <h1>You don't have any notifications!</h1>
            <p>Notifications appear here when someone doing something related to you.</p>
        </div>
    @endif
@endsection
