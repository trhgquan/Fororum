<ul class="nav nav-tabs">
    <li role="presentation" class="{{ ($action === 'home') ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hệ thống <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ route('admin.index') }}">Tổng quan</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('admin.root.user') }}">Tài khoản</a></li>
            <li><a href="{{ route('admin.root.post') }}">Bài đăng</a></li>
        </ul>
    </li>
    <li role="presentation" class="{{ ($action === 'report') ? 'active' : '' }}">
        <a href="{{ ($action === 'report') ? '#' : route('admin.report') }}">Báo cáo <span class="badge">{{ App\UserReport::not_reviewed() }}</span></a>
    </li>
    <li role="presentation" class="{{ ($action === 'staff') ? 'active' : '' }}">
        <a href="{{ ($action === 'staff') ? '#' : route('admin.root.staff') }}">Nhân sự</a>
    </li>
</ul>
