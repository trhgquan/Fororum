<ul class="list-group">
    <a href="{{ route('admin.index') }}" class="list-group-item {{ ($action === 'home') ? 'active' : '' }}">
        Hệ thống
    </a>
    <a href="{{ route('admin.report') }}" class="list-group-item {{ ($action === 'report') ? 'active' : '' }}">
        Báo cáo <span class="badge">{{ App\UserReport::not_reviewed() }}</span>
    </a>
    <a href="{{ route('admin.staff') }}" class="list-group-item {{ ($action === 'staff') ? 'active' : '' }}">
        Nhân sự
    </a>
</ul>
