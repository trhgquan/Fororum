<!DOCTYPE html>
<html>
	<head>
		<title>{{ config('app.name') }} - @yield('title')</title>
		<!-- NOW IS THE META! -->
		@include('templates.meta-template')
		<!-- STYLES -->
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/main.css') }}">
	</head>

	<body>
		<!-- NAVIGATION BAR FOR THE WEBSITE -->
		@section('navbar')
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					@section('navbar_brand')
						<a href="{{ url('/') }}" class="navbar-brand">{{ config('app.name') }}</a>
					@show
				</div>

				<ul class="nav navbar-nav navbar-right">
					@yield('navbar_item')
				</ul>
			</div>
		</nav>
		@show

		<!-- WEBSITE CONTENT -->
		<div class="container">
			@yield('content')
		</div>

		<!-- PLACE THE JAVASCRIPT BEFORE ENDING THE BODY, WILL MAKE THE PAGE LOAD FASTER -->
		<script src="{{ url('js/jquery.js') }}"></script>
		<script src="{{ url('js/bootstrap.min.js') }}"></script>
		@yield('extrajs')

		<!-- FOOTER -->
		<footer class="footer">
			<div class="navbar navbar-default">
				<div class="container">
					@section ('footer')
						@isset($footer)
							@foreach ($footer as $footer_item)
								<p class="navbar-text">{!! $footer_item !!}</p>
							@endforeach
						@endisset
					@show
					<p class="navbar-text">{{ config('app.name') }} is powered by <b><a href="https://github.com/trhgquan/Fororum">Fororum</a></b>. Copyright &copy; 2018 <a href="https://github.com/trhgquan">Quan, Tran Hoang</a> under <a href="https://github.com/trhgquan/Fororum/blob/master/LICENSE">the MIT License</a>.</p>
				</div>
			</div>
		</footer>
	</body>
</html>
