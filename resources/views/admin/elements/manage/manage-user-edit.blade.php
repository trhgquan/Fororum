<div class="panel panel-primary">
    <div class="panel-heading">
        Chỉnh sửa thông tin tài khoản người dùng
    </div>

    <div class="panel-body">
        @include('forms.admin.admin-search-form')
        <table class="table table-bordered">
            <thead>
                <th>ID</th>
                <th>Tài khoản</th>
                <th>Đặc quyền</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @foreach ($users_raw as $user)
                    @include('forms.admin.account.account-edit', [
                        'user' => App\User::find($user->id),
                        'permissions' => App\UserInformation::userPermissions($user->id)
                    ])
                @endforeach
            </tbody>
        </table>
        {{ $users_raw->links() }}
    </div>
</div>
