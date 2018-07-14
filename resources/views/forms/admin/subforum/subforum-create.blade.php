<form action="#">
    <div class="form-group">
        <label class="control-label">Tên diễn đàn con</label>
        <input type="text" name="subforum_title" class="form-control" required>
    </div>

    <div class="form-group">
        <label class="control-label">Giới thiệu diễn đàn con</label>
        <textarea name="subforum_description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label class="control-label">Từ khóa</label>
        <div class="input-group">
            <div class="input-group-addon">
                {{ route('forum') }}/
            </div>
            <input type="text" name="subforum_keyword" class="form-control" required>
            <div class="input-group-btn">
                <button class="btn btn-primary" name="randomize" onclick="return false;">Ngẫu nhiên</button>
            </div>
        </div>
    </div>

    <div class="form-group has-error">
        @csrf
        <p class="help-block" style="text-align: justify;">
            <b>Cảnh báo: Khi đã tạo subforum, bạn không thể thực hiện hành động ngược lại (xóa subforum).</b><br/>
            Một subforum chứa trong đó rất nhiều chủ đề (topic) và các bài viết bình luận. Việc xóa một subforum sẽ ảnh hưởng <b>rất lớn</b> tới các chủ đề này. Do vậy, chúng tôi tạm thời không hỗ trợ tính năng xóa subforum.
        </p>
        <input type="checkbox" name="confirm" required> Tôi đã đọc kỹ và vẫn muốn tiếp tục
    </div>
    <button class="btn btn-success">Tạo diễn đàn con</button>
</form>
@section('extrajs')
    <script src="{{ url('js/generate.js') }}"></script>
@endsection
