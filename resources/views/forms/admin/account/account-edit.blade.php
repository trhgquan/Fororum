<form action="{{ route('admin.edit.user.save') }}" method="POST">
    <tr>
        <td>
            <a href="{{ route('user.profile.username', [$user->username]) }}">{{ $user->id }}</a>
            <input type="hidden" name="id" value="{{ $user->id }}">
            @component('templates.badges-template', ['o' => App\UserInformation::userPermissions($user->id)])
            @endcomponent
        </td>
        <td>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
        </td>
        <td>
            <select name="permissions" class="form-control">
                <option value="1">Người dùng</option>
                <option value="2">Tài khoản chính thức</option>
                <option value="3">Người kiểm duyệt</option>
            </select>
        </td>
        <td>
            @csrf
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </td>
    </tr>
</form>
