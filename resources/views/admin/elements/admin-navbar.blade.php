<ul class="nav nav-tabs">
    <li role="presentation" class="{{ ($action === 'home') ? 'active' : '' }}">
        <a href="{{ route('admin.home') }}">Hệ thống</a>
    </li>
    <li role="presentation">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Quản lý
            @if (App\UserReport::not_reviewed()['total'] > 0)
                <span class="badge">{{ App\UserReport::not_reviewed()['total'] }}</span>
            @endif
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li class="dropdown-header">Tài khoản</li>
            <li class="{{ ($action === 'management' && $role === 'user') ? 'active' : '' }}">
                <a href="{{ route('admin.profiles-manager.reports') }}">
                    Báo cáo tài khoản
                    @if (App\UserReport::not_reviewed()['total'] > 0)
                        <span class="badge">{{ App\UserReport::not_reviewed()['profile'] }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ ($action === 'editUser') ? 'active' : '' }}">
                <a href="{{ route('admin.profiles-manager.home') }}">
                    Sửa thông tin tài khoản
                </a>
            </li>
            <li class="divider" role="seperator"></li>
            <li class="dropdown-header">Diễn đàn</li>
            <li class="{{ ($action === 'management' && $role === 'post') ? 'active' : '' }}">
                <a href="{{ route('admin.manage.post') }}">
                    Báo cáo bài đăng
                    @if (App\UserReport::not_reviewed()['total'] > 0)
                        <span class="badge">{{ App\UserReport::not_reviewed()['post'] }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ ($action === 'subforum') ? 'active' : '' }}">
                <a href="{{ route('admin.manage.subforum') }}">
                    Diễn đàn con
                </a>
            </li>
        </ul>
    </li>
</ul>
