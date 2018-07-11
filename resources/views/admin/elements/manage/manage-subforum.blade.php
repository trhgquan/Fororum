<table class="table table-bordered">
    <thead>
        <th>#</th>
        <th>Tên diễn đàn con</th>
        <th>Motto</th>
        <th>Keyword</th>
        <th>Actionale</th>
    </thead>

    <tbody>
        @foreach ($subforums as $forum)
            @include('forms.admin.subforum.subforum-edit')
        @endforeach
    </tbody>
</table>
{{ $subforums->links() }}
