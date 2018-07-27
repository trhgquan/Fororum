<form class="form-inline" action="{{ route('admin.edit.user.search') }}" method="POST">
    <div class="form-group">
        <label for="keyword">Tìm một người dùng:</label>
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" value="{{ (isset($keyword) && strlen($keyword) > 0) ? $keyword : '' }}" placeholder="keyword" required>
            @csrf
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </div>
        </div>
    </div>
</form>