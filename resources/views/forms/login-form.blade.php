<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			Log into your account
		</div>
		<div class="panel-body">
			<form action="{{ route('login') }}" method="POST" role="form">
				@if ($errors->has('content'))
					@component('templates.alert-template', ['alert_class'=>$errors->first('class'),'alert_title' => $errors->first('title'), 'alert_content'=>$errors->first('content')])
					@endcomponent
				@endif

				<div class="form-group {{ ($errors->has('username')) ? 'has-error' : '' }}">
					<label class="control-label" for="username">Username:</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Your username" value="{{ old('username') }}" required>
					@if ($errors->has('username'))
						<span class="help-block">{{ $errors->first('username') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }} ">
					<label class="control-label" for="password">Password:</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Your password" required>
					@if ($errors->has('password'))
						<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>

				@csrf

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-centered">Login</button>
					<hr>
					<a href="{{ route('register') }}">Don't have an account yet? Get one now!</a>
				</div>
			</form>
		</div>
	</div>
</div>
