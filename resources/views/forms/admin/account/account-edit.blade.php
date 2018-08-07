<form action="{{ route('admin.edit.user.save') }}" method="POST">
    <tr>
        <td>
            <a href="{{ route('user.profile.username', [$user->username]) }}">{{ $user->id }}</a>
            <input type="hidden" name="id" value="{{ $user->id }}">
            @component('templates.badges-template', ['o' => $permissions])
            @endcomponent
        </td>
        <td>
            @if (!$permissions['admin'] && !$permissions['banned'])
                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
            @else
                <label for="username">{{ $user->username }}</label>
            @endif
        </td>
        <td>
            @if (!$permissions['admin'] && !$permissions['banned'])
                <select name="permissions" class="form-control">
                    <option value="1">Người dùng</option>
                    <option value="2">Tài khoản chính thức</option>
                    <option value="3">Người kiểm duyệt</option>
                </select>
            @else
                <p class="text-danger">không thể chỉnh đặc quyền</p>
            @endif
        </td>
        <td>
            @csrf
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </td>
    </tr>
</form>
