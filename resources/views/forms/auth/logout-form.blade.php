<li><a href="{{ route('auth.logout') }}" onclick="event.preventDefault();document.getElementsByName('logout')[0].submit();">Log out</a></li>
<form name="logout" action="{{ route('auth.logout') }}" style="display:none;" method="POST">
    @csrf
</form>
