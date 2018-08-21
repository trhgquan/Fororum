<form action="{{ route('admin.profiles-manager.edit') }}" method="POST">
    <tr>
        <td>
            <a href="{{ route('profile.user', [$user->username]) }}">{{ $user->id }}</a>
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
                    <option value="1">Normal profile</option>
                    <option value="2" {{ (!$permissions['confirmed']) ?: 'selected' }}>Official profile</option>
                    <option value="3" {{ (!$permissions['mod']) ?: 'selected' }}>Garde du corps</option>
                </select>
            @else
                <p class="text-danger">
                    Cannot take any action with this user. <br>
                    Reason:
                    @if ($permissions['admin'])
                        Administrator
                    @else
                        banned until {{ date_format(new DateTime(App\UserBlacklists::reason($user->id)['expire']), 'h:i:s A T, d-m-Y') }} by {{ App\User::username(App\UserBlacklists::reason($user->id)['admin_id']) }}
                    @endif
                </p>
            @endif
        </td>
        <td>
            @csrf
            @if (!$permissions['admin'] && !$permissions['banned'])
                <button type="submit" class="btn btn-primary">Save</button>
            @endif
        </td>
    </tr>
</form>
