<div class="col-md-6 col-md-offset-3">
    <div class="notify-title">
        <h1>{{ config('app.name') }} <small>search</small></h1>
        <p>find a profile or a post on {{ config('app.name') }}</p>
    </div>

    <form action="{{ route('search.keyword') }}" method="POST">
        <div class="form-group {{ ($errors->has('keyword') ? 'has-error' : '') }}">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Ex: syria" required>
                @csrf
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-{{ $errors->has('keyword') ? 'danger' : 'default' }}">Search</button>
                </div>
            </div>
            @if ($errors->has('keyword'))
                <span class="help-block">{{ $errors->first('keyword') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label class="control-label">you are looking for </label>
            <label class="radio-inline"><input type="radio" name="action" value="profile" checked> a profile</label>
            <label class="radio-inline"><input type="radio" name="action" value="post"> a post</label>
        </div>
    </form>
</div>
