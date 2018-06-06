<ul class="list-group">
    <a href="{{ ($action == 'user') ? '#' : route('search', ['keyword' => $keyword, 'action' => 'user']) }}" class="list-group-item {{ ($action == 'user') ? 'active' : '' }}">
        tài khoản
        <span class="badge">{{ $results['user']->total() }}</span>
    </a>
    <a href="{{ ($action == 'post') ? '#' : route('search', ['keyword' => $keyword, 'action' => 'post']) }}" class="list-group-item {{ ($action == 'post') ? 'active' : '' }}">
        bài đăng
        <span class="badge">{{ $results['post']->total() }}</span>
    </a>
</ul>
<p><a href="{{ route('searchIndex') }}">quay trở lại trang tìm kiếm</a></p>
