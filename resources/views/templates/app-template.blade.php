<!DOCTYPE html>
<html>
	<head>
		<title>{{ config('app.name') }} - @yield('title')</title>
		<!-- NOW IS THE META! -->
		@include('templates.meta-template')
		<!-- STYLES -->
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/Fororum.css') }}">
	</head>

	<body>
		<!-- NAVIGATION BAR FOR THE WEBSITE -->
		@section('navbar')
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					@section('navbar_brand')
						<a href="{{ url('/') }}" class="navbar-brand">
							{{ config('app.name') }}
							@isset ($navbar_brand)
								<small>{{ $navbar_brand }}</small>
							@endisset
						</a>
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

		<!-- FOOTER -->
		<footer class="footer">
			<div class="navbar navbar-default">
				<div class="container">
					@section ('footer')
						@isset($footer)
							@if (is_array($footer))
								@foreach ($footer as $footer_item)
									<p class="navbar-text">{!! $footer_item !!}</p>
								@endforeach
							@else
								<p class="navbar-text">{!! $footer !!}</p>
							@endif
						@endisset
					@show
					<p class="navbar-text">
						{{ config('app.name') }} is powered by <b><a href="https://github.com/trhgquan/Fororum">Fororum</a></b>.
						Copyright &copy; <span id="currentYear"></span> <a href="https://github.com/trhgquan">Quan, Tran Hoang</a> under <a href="https://github.com/trhgquan/Fororum/blob/master/LICENSE">the MIT License</a>.
					</p>
				</div>
			</div>
		</footer>

    <!-- PLACE THE JAVASCRIPT BEFORE ENDING THE BODY, WILL MAKE THE PAGE LOAD FASTER -->
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/fororum-year.js') }}"></script>
    @yield('extrajs')
	</body>
</html>
