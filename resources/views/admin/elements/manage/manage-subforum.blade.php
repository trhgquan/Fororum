<table class="table table-bordered">
    <thead>
        <th>#</th>
        <th>Subforum</th>
        <th>Intro</th>
        <th>Slug</th>
        <th>Action</th>
    </thead>

    <tbody>
        @foreach ($subforums as $forum)
            @include('forms.admin.subforum.subforum-edit')
        @endforeach
    </tbody>
</table>
{{ $subforums->links() }}
