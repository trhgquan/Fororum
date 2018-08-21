<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
	<ul class="dropdown-menu">
		<li><a href="{{ route('profile.user', [Auth::user()->username]) }}">Your profile</a></li>
		<li><a href="{{ route('profile.edit') }}">Edit your profile</a></li>
		<li role="separator" class="divider"></li>
		@include('forms.auth.logout-form')
	</ul>
</li>
