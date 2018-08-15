<div class="row">
    <div class="col-md-4">
        <div class="media-box">
            <h3><a href="{{ route('admin.profiles-manager.home') }}">{{ App\User::count() }} accounts</a></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="media-box">
            <h3><a href="{{ route('admin.forum-manager.subforum') }}">{{ App\ForumCategories::count() }} subforums</a></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="media-box">
            <h3><a href="{{ route('admin.forum-manager.post') }}">{{ App\ForumPosts::count() }} posts</a></h3>
        </div>
    </div>
</div>
