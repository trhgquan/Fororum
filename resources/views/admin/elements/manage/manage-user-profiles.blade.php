<div class="panel panel-primary">
    <div class="panel-heading">
        Edit user's information
    </div>

    <div class="panel-body">
        @include('forms.admin.admin-search-form')
        <table class="table table-bordered">
            <thead>
                <th>ID</th>
                <th>Account</th>
                <th>Permissions</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($users_raw as $user)
                    @include('forms.admin.account.account-edit', [
                        'user'        => App\User::find($user->id),
                        'permissions' => App\UserInformation::userPermissions($user->id)
                    ])
                @endforeach
            </tbody>
        </table>
        {{ $users_raw->links() }}
    </div>
</div>
