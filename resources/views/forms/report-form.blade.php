@component('templates.alert-template', [
    'alert_title' => 'Chú ý',
    'alert_class' => 'info',
    'alert_content' => 'Hãy chắc chắn bạn đã báo cáo đúng tài khoản / bài đăng. Mọi sai sót sẽ dẫn đến báo cáo của bạn bị bác bỏ.'
])
@endcomponent
<form action="{{ route('report.handle') }}" method="POST">
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
