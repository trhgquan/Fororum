<ul class="nav nav-tabs">
    <li role="presentation" class="{{ ($action === 'home') ? 'active' : '' }}">
        <a href="{{ route('admin.home') }}">Dashboard</a>
    </li>
    <li role="presentation">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Actions
            @if (App\UserReport::not_reviewed()['total'] > 0)
                <span class="badge">{{ App\UserReport::not_reviewed()['total'] }}</span>
            @endif
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li class="dropdown-header">Accounts</li>
            <li class="{{ ($action === 'management' && $role === 'user') ? 'active' : '' }}">
                <a href="{{ route('admin.profiles-manager.reports') }}">
                    Account reports
                    @if (App\UserReport::not_reviewed()['total'] > 0)
                        <span class="badge">{{ App\UserReport::not_reviewed()['profile'] }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ ($action === 'editUser') ? 'active' : '' }}">
                <a href="{{ route('admin.profiles-manager.home') }}">
                    Edit user's information
                </a>
            </li>
            <li class="divider" role="seperator"></li>
            <li class="dropdown-header">Forum</li>
            <li class="{{ ($action === 'management' && $role === 'post') ? 'active' : '' }}">
                <a href="{{ route('admin.manage.post') }}">
                    Forum reports
                    @if (App\UserReport::not_reviewed()['total'] > 0)
                        <span class="badge">{{ App\UserReport::not_reviewed()['post'] }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ ($action === 'subforum') ? 'active' : '' }}">
                <a href="{{ route('admin.manage.subforum') }}">
                    Subforums
                </a>
            </li>
        </ul>
    </li>
</ul>
