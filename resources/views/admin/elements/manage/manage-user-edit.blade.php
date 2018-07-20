<div class="panel panel-primary">
    <div class="panel-heading">
        Chỉnh sửa thông tin tài khoản người dùng
    </div>

    <div class="panel-body">
        @include('forms.admin.admin-search-form')
        @if (empty($users_raw->total()))
            @component('templates.alert-template', [
                'alert_class' => 'warning',
                'alert_title' => 'Lỗi',
                'alert_content' => 'Không tìm thấy người dùng này, hãy thay đổi từ khóa và thử lại'
            ])
            @endcomponent
            @php
                $users_raw = App\UserInformation::getActiveUsers();
            @endphp
        @endif
        <table class="table table-bordered">
            <thead>
                <th>ID</th>
                <th>Tài khoản</th>
                <th>Đặc quyền</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @foreach ($users_raw as $users)
                    @php
                        $user = App\User::find($users->id);
                    @endphp
                    @include('forms.admin.account.account-edit')
                @endforeach
            </tbody>
        </table>
        {{ $users_raw->links() }}
    </div>
</div>
