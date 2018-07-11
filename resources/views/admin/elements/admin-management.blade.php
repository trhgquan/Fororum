@if ($role === 'user')
    @include('admin.elements.manage.manage-user', ['reports' => App\UserReport::getUsersOnly()])
@else
    <div class="notify-title">
        <h1>Tính năng đang được xây dựng</h1>
        <p><a href="https://github.com/trhgquan">github</a></p>
    </div>
@endif
