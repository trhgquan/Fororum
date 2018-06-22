@if ($errors->has('class'))
    @component('templates.alert-template', [
        'alert_title' => 'Thông báo',
        'alert_class' => $errors->first('class'),
        'alert_content' => $errors->first('content')
    ])
    @endcomponent
@endif
@if (App\UserReport::not_reviewed() > 0)
    @foreach ($reports as $report)
        <div class="media-box">
            <form action="{{ route('admin.censor') }}" method="POST">
                <div class="form-group">
                    <label class="control-label">
                        <p>Link đối tượng bị report:
                            <a href="{{ route((($report->type === 'profile') ? 'user.profile.username' : 'post'), [(($report->type === 'profile') ? App\User::username($report->participant_id) : $report->participant_id)]) }}">
                                {{ App\UserReport::participant_title($report->participant_id, $report->type) }}
                            </a>
                        </p>
                        <p>Lý do:</p>
                    </label>
                    <blockquote>
                        {{ $report->reason }}
                        <footer>
                            {{ App\User::username($report->user_id) }}
                        </footer>
                    </blockquote>
                </div>

                <div class="form-group">
                    @csrf
                    <input type="hidden" name="rpid" value="{{ $report->id }}">
                    <button type="submit" name="action" value="accept" class="btn btn-primary">Duyệt</button>
                    <button type="submit" name="action" value="reject" class="btn btn-danger">Bác</button>
                </div>
            </form>
        </div>
    @endforeach
    {{ $reports->links() }}
@else
    <div class="notify-title">
        <h1>Chưa có báo cáo từ người dùng</h1>
        <p>Nếu có, chúng sẽ xuất hiện tại đây.</p>
    </div>
@endif
