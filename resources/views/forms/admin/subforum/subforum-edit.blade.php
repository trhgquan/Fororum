<form action="{{ route('admin.manage.subforum.edit') }}" method="POST">
    <tr>
        <td><input type="hidden" name="id" value="{{ $forum->id }}"><a href="{{ route('category', ['forum_category' => $forum->keyword]) }}">{{ $forum->id }}</a></td>
        <td><input type="text" class="form-control" name="title" value="{{ $forum->title }}" required></td>
        <td><textarea class="form-control" name="description" required>{{ $forum->description }}</textarea></td>
        <td><input type="text" class="form-control" name="keyword" value="{{ $forum->keyword }}" required></td>
        <td>
            @csrf
            <button type="submit" name="action" value="edit" class="btn btn-primary">Save</button>
        </td>
    </tr>
</form>
