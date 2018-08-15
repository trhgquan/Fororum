<form action="{{ route('admin.forum-manager.subforum.create') }}" method="POST">
    <div class="form-group">
        <label class="control-label">Subforum's name</label>
        <input type="text" name="subforum_title" class="form-control" placeholder="Annuntio vobis gaudium magnum" required>
    </div>

    <div class="form-group">
        <label class="control-label">Subforum's description</label>
        <textarea name="subforum_description" class="form-control" placeholder="Lorem ipsum dolor sit amet orci aliquam." required></textarea>
    </div>

    <div class="form-group">
        <label class="control-label">Slug</label>
        <div class="input-group">
            <div class="input-group-addon">
                {{ route('forum') }}/
            </div>
            <input type="text" name="subforum_keyword" class="form-control" placeholder="annuntio-vobis-gaudium-magnum" required>
            <div class="input-group-btn">
                <button type="button" class="btn btn-primary" name="randomize">Generate</button>
            </div>
        </div>
    </div>

    <div class="form-group has-error">
        @csrf
        <p class="help-block" style="text-align: justify;">
            <b>Warning: You cannot reverse this action.</b><br/>
            A subforum may contains itself many threads and posts. Delete it will also delete all of its reply posts. Be careful before take this action.
        </p>
        <input type="checkbox" name="confirm" required> I have carefully read the warning and willing to create a subforum.
    </div>
    <button class="btn btn-success">Create a new subforum</button>
</form>
@section('extrajs')
    <script src="{{ url('js/generate.js') }}"></script>
@endsection
