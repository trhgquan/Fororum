<li><a href="{{ route('notify.home') }}">Notification
    @if (!empty((Auth::user())->unreadNotifications->count()))
        <span class="badge">{{ (Auth::user())->unreadNotifications->count() }}</span>
    @endif
</a></li>
