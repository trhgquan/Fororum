<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
	<ul class="dropdown-menu">
		<li><a href="{{ route('user.profile.home') }}">Trang hồ sơ</a></li>
		<li><a href="{{ route('user.edit') }}">Chỉnh sửa thông tin</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementsByName('logout')[0].submit();">Đăng xuất</a></li>
		<form name="logout" action="{{ route('logout') }}" style="display:none;" method="POST">
			@csrf
		</form>
	</ul>
</li>
