<ul class="list-group">
    <a href="{{ ($action == 'profile') ? '#' : route('search', ['keyword' => $keyword, 'action' => 'profile']) }}" class="list-group-item {{ ($action == 'profile') ? 'active' : '' }}">
        Profiles
        <span class="badge">{{ $results['profile']->total() }}</span>
    </a>
    <a href="{{ ($action == 'post') ? '#' : route('search', ['keyword' => $keyword, 'action' => 'post']) }}" class="list-group-item {{ ($action == 'post') ? 'active' : '' }}">
        Posts
        <span class="badge">{{ $results['post']->total() }}</span>
    </a>
</ul>
<p><a href="{{ route('search.home') }}">back to the search engine.</a></p>
