<ul class="nav nav-tabs">
    <li role="presentation">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hệ thống <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li class="{{ ($action === 'home') ? 'active' : '' }}"><a href="{{ route('admin.index') }}">Tổng quan</a></li>
            <li role="separator" class="divider"></li>
            <li class="{{ ($action === 'management' && $role === 'user') ? 'active' : '' }}"><a href="{{ route('admin.root.user') }}">Tài khoản</a></li>
            <li class="{{ ($action === 'management' && $role === 'post') ? 'active' : '' }}"><a href="{{ route('admin.root.post') }}">Bài đăng</a></li>
        </ul>
    </li>
    <li role="presentation" class="{{ ($action === 'report') ? 'active' : '' }}">
        <a href="{{ ($action === 'report') ? '#' : route('admin.report') }}">Báo cáo <span class="badge">{{ App\UserReport::not_reviewed() }}</span></a>
    </li>
</ul>
