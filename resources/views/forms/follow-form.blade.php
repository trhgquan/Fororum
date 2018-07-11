@if (!$this_profile)
    <form action="{{ route('user.profile.username.follow', ['username' => $content['user_content']->username]) }}" method="POST">
        <input type="hidden" name="uid" value="{{ $content['user_content']->id }}">
        @csrf
        @if (!App\UserFollowers::is_followed(Auth::id(), $content['user_content']->id))
            <button type="submit" class="btn btn-primary">Đăng ký</button>
        @else
            <button type="submit" class="btn btn-danger">Huỷ đăng ký</button>
        @endif
    </form>
@endif
