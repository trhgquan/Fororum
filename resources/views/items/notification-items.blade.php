<li><a href="{{ url('/notify') }}">Thông báo
    @if (!empty(App\UserNotification::count(Auth::id())))
        <span class="badge">{{ App\UserNotification::count(Auth::id()) }}</span>
    @endif
</a></li>
