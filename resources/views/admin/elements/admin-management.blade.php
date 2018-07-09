@if ($role === 'post')
    Quản lý bài đăng.
@else
    @if ($errors->has('class'))
        @component('templates.alert-template', [
            'alert_title' => 'Thông báo',
            'alert_class' => $errors->first('class'),
            'alert_content' => $errors->first('content')
        ])
        @endcomponent
    @endif
    @include('admin.elements.manage.manage-user', ['reports' => App\UserReport::getUsersOnly()])
@endif
