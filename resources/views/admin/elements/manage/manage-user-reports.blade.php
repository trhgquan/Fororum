@if ($reports->count() > 0)
    <table class="table table-bordered">
        <thead>
            <th>ID</th>
            <th>Account</th>
            <th>Report / Reporter</th>
            <th>At</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->participant_id }}</td>
                    <td>
                        <a href="{{ route('profile.user', [App\User::username($report->participant_id)]) }}">{{ App\User::username($report->participant_id) }}</a>
                        @component('templates.badges-template', [
                            'o' => App\UserInformation::userPermissions($report->participant_id)
                        ])
                        @endcomponent
                    </td>
                    <td>
                        <blockquote>
                            {{ $report->reason }}
                            <footer>
                                <a href="{{ route('profile.user', [App\User::username($report->user_id)]) }}">{{ App\User::username($report->user_id) }}</a>
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
        <h1>No reports could be found.</h1>
        <p>If there are any reports, it will appear here.</p>
    </div>
@endif
