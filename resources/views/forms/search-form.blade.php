<div class="col-md-6 col-md-offset-3">
    <div class="notify-title">
        <h1>{{ config('app.name') }} <small>search</small></h1>
        <p>tìm một tài khoản nào đó, hay một bài đăng</p>
    </div>

    <form action="{{ route('search.keyword') }}" method="POST">
        <div class="form-group {{ ($errors->has('keyword') ? 'has-error' : '') }}">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Ex: syria" required>
                <input type="hidden" name="action" value="profile">
                @csrf
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-{{ $errors->has('keyword') ? 'danger' : 'default' }}">Tìm</button>
                </div>
            </div>
            @if ($errors->has('keyword'))
                <span class="help-block">{{ $errors->first('keyword') }}</span>
            @endif
        </div>
    </form>
</div>
