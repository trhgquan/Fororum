<form action="{{ route('admin.profiles-manager.takedown') }}" method="POST">
    <div class="form-group">
        @csrf
        <input type="hidden" name="rpid" value="{{ $report->id }}">
        @if (!App\UserInformation::userPermissions($report->participant_id)['admin'])
            @if (!App\UserInformation::userPermissions($report->participant_id)['banned'])
                <select class="form-control" name="expire">
                    <option value="1 month">Khóa 1 tháng</option>
                    <option value="1 year">Khóa 1 năm</option>
                    <option value="1000 year">Khóa vĩnh viễn</option>
                </select>
             @endif
        @endif
    </div>

    <div class="form-group">
        @if (!App\UserInformation::userPermissions($report->participant_id)['admin'])
            @if (!App\UserInformation::userPermissions($report->participant_id)['banned'])
                <button type="submit" name="action" value="accept" class="btn btn-danger">khóa</button>
            @endif
        @endif
        <button type="submit" name="action" value="reject" class="btn btn-primary">bác bỏ</button>
    </div>
</form>
