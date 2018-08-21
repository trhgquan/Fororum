<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			Register a new {{ config('app.name') }} account.
		</div>
		<div class="panel-body">
			<form action="{{ route('auth.register') }}" method="POST" role="form">
				<div class="form-group {{ ($errors->has('username')) ? 'has-error' : '' }}">
					<label class="control-label" for="username">Pick a username:</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Your username" value="{{ old('username') }}" required>
					@if ($errors->has('username'))
						<span class="help-block">{{ $errors->first('username') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password_confirmation') || $errors->has('password')) ? 'has-error' : '' }}">
					<label class="control-label" for="password">Choose your password:</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Your password" required>
					@if ($errors->has('password_confirmation') || $errors->has('password'))
						<span class="help-block">{{ ($errors->has('password_confirmation')) ? $errors->first('password_confirmation') : $errors->first('password') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
					<label class="control-label" for="password_confirmation">Password confirmation:</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password confirmation" required>
					@if ($errors->has('password_confirmation'))
						<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
					<label class="control-label" for="email">Email:</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Your email" value="{{ old('email') }}" required>
					@if ($errors->has('email'))
						<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>

				<div class="checkbox {{ $errors->has('agrees') ? 'has-error' : '' }}">
					<label class="control-label" for="agrees">
						<div class="checkbox">
							<input type="checkbox" id="agrees" name="agrees">
						</div>
						I HAVE READ CAREFULLY AND AGREED WITH THE <a href="#">TERMS OF SERVICE</a> AND THE <a href="#">USER AGREEMENT</a> OF {{ config('app.name') }}
					</label>
				</div>

				@csrf

				<button type="submit" class="btn btn-success">Sign up</button>
				<hr/>
				<a href="{{ route('auth.login') }}">Already have an account? Log in!</a>
			</form>
		</div>
	</div>
</div>
