<html>
	<head>
		<title>{{ config('app.name') }} - @yield('title')</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/main.css') }}">
		<style type="text/css">
			@yield('extracss')
		</style>
	</head>

	<body>
		@section('navbar')
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					@section('navbar-brand')
						<a href="{{ url('/') }}" class="navbar-brand">{{ config('app.name') }}</a>
					@show
				</div>

				<ul class="nav navbar-nav navbar-right">
					@yield('navbar_item')
				</ul>
			</div>
		</nav>
		@show

		<div class="container">
			@yield('content')
		</div>

		<script src="{{ url('js/jquery.js') }}"></script>
		<script src="{{ url('js/bootstrap.min.js') }}"></script>
		{{-- <script src="{{ url('js/action.js') }}"></script> --}}
		@yield('extrajs')
	</body>

	<footer>
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<div class="navbar">
					<p class="navbar-text">Bản quyền bởi <strong>{{ config('app.name') }}</strong> &copy; @php echo date('Y') @endphp. Mọi quyền được bảo lưu.</p>
				</div>
			</div>
		</div>
	</footer>
</html>
