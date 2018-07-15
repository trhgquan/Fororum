<table class="table table-bordered">
    <thead>
        <th>#</th>
        <th>Tên diễn đàn con</th>
        <th>Giới thiệu</th>
        <th>Từ khóa</th>
        <th>Hành động</th>
    </thead>

    <tbody>
        @foreach ($subforums as $forum)
            @include('forms.admin.subforum.subforum-edit')
        @endforeach
    </tbody>
</table>
{{ $subforums->links() }}
