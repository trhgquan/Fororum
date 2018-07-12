<form action="{{ route('admin.manage.subforum.edit') }}" method="POST">
    <tr>
        <td><input type="hidden" name="id" value="{{ $forum->id }}"><a href="{{ route('category', ['forum_category' => $forum->keyword]) }}">{{ $forum->id }}</a></td>
        <td><input type="text" class="form-control" name="title" value="{{ $forum->title }}"></td>
        <td><textarea class="form-control" name="description">{{ $forum->description }}</textarea></td>
        <td><input type="text" class="form-control" name="keyword" value="{{ $forum->keyword }}"></td>
        <td>
            @csrf
            <button type="submit" name="action" value="edit" class="btn btn-primary">Sửa</button>
        </td>
    </tr>
</form>
