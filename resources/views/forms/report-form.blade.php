<div class="panel panel-danger">
    <div class="panel-heading">
        Bao cao {{ ($section === 'profile') ? 'tài khoản' : 'bài viết' }}
    </div>

    <div class="panel-body">
        <form action="{{ route('report.handle') }}" method="POST">
            <div class="form-group">
                <label class="control-label">Lưu ý: đọc kỹ trước khi gửi báo cáo:</label>
                <p>Nếu bạn cảm thấy một {{ ($section === 'profile') ? 'tài khoản' : 'bài viết' }} vi phạm <a href="#">điều khoản dịch vụ</a> hay <a href="#">chính sách người dùng</a>, vui lòng dùng form bên dưới để gửi báo cáo cho quản trị viên. Quản trị viên sẽ xem xét và đưa ra những hình thức xử lý phù hợp.</p>
                <p>Không nên dùng form này để gửi báo cáo lỗi hay yêu cầu chức năng, vì những báo cáo này sẽ được duyệt bởi quản trị viên hệ thống, không phải nhà phát triển.</p>
                <p>Hãy chắc chắn bạn đã báo cáo đúng {{ ($section === 'profile') ? 'tài khoản' : 'bài viết' }}. Mọi sai sót sẽ dẫn đến báo cáo của bạn bị bác bỏ, xa hơn là tài khoản của bạn có thể bị đình chỉ vì báo cáo sai lệch.</p>
            </div>
            <div class="form-group">
                <label>
                    Bạn đang báo cáo {{ ($section === 'profile') ? 'tài khoản' : 'bài viết' }}
                    {{ App\UserReport::participant_title($ppid, $section) }}
                </label>
            </div>
            <div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
                <label class="control-label" for="reason">Chi tiết báo cáo:</label>
                <textarea class="form-control" name="reason" id="reason" placeholder="Chi tiết báo cáo của bạn" required></textarea>
                @if ($errors->has('reason'))
                    <span class="help-block">{{ $errors->first('reason') }}</span>
                @endif
            </div>
            <input type="hidden" name="ppid" value="{{ $ppid }}">
            <input type="hidden" name="section" value="{{ $section }}">
            @csrf
            <button type="submit" class="btn btn-danger">Báo cáo</button>
        </form>
    </div>
</div>
