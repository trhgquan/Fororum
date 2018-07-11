@if ($reports->count() > 0)
    <table class="table table-bordered">
        <thead>
            <th>ID</th>
            <th>Tài khoản</th>
            <th>Báo cáo / Người báo cáo</th>
            <th>Lúc</th>
            <th>Hành động</th>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->participant_id }}</td>
                    <td>
                        <a href="{{ route('user.profile.username', [App\User::username($report->participant_id)]) }}">{{ App\User::username($report->participant_id) }}</a>
                        @component('templates.badges-template', [
                            'o' => App\UserInformation::userPermissions($report->participant_id)
                        ])
                        @endcomponent
                    </td>
                    <td>
                        <blockquote>
                            {{ $report->reason }}
                            <footer>
                                <a href="{{ route('user.profile.username', [App\User::username($report->user_id)]) }}">{{ App\User::username($report->user_id) }}</a>
                            </footer>
                        </blockquote>
                    </td>
                    <td>{{ date_format($report->created_at, 'h:i:s A T, d-m-Y') }}</td>
                    <td>
                        @include('forms.admin.report-action')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $reports->links() }}
@else
    <div class="notify-title">
        <h1>Không có thông tin!</h1>
        <p>Những tài khoản bị báo cáo sẽ xuất hiện tại đây</p>
    </div>
@endif
