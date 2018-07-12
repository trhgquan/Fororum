<form action="#">
    <div class="form-group">
        <label class="control-label">Tên diễn đàn con</label>
        <input type="text" name="subforum_title" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label">Giới thiệu diễn đàn con</label>
        <textarea name="subforum_description" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label class="control-label">Từ khóa</label>
        <input type="text" name="subforum_keyword" class="form-control">
    </div>

    <div class="form-group has-error">
        @csrf
        <p class="help-block" style="text-align: justify;">
            <b>Cảnh báo</b>: Khi đã tạo subforum, bạn không thể thực hiện hành động ngược lại (xóa subforum).<br/>
            Một subforum chứa trong đó rất nhiều chủ đề (topic) và các bài viết bình luận. Việc xóa một subforum sẽ ảnh hưởng <b>rất lớn</b> tới các chủ đề này. Do đó, cẩn trọng trước khi tạo một subforum.
        </p>
        <button class="btn btn-success">Tạo diễn đàn con</button>
    </div>
</form>
