<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-danger">
		<div class="panel-heading">
			Edit your password
		</div>
		<div class="panel-body">
			<form action="{{ route('user.edit.password') }}" method="POST" role="form">
				@if ($errors->has('content'))
					@component('templates.alert-template', ['alert_class'=>$errors->first('class'),'alert_title' => $errors->first('title'), 'alert_content'=>$errors->first('content')])
					@endcomponent
				@endif

				<div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
					<label class="control-label" for="password">Your current password:</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Your current password" required>
					@if ($errors->has('password'))
						<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password_confirmation') || $errors->has('new_password')) ? 'has-error' : '' }}">
					<label class="control-label" for="new_password">Your new password:</label>
					<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Your new password" required>
					@if ($errors->has('password_confirmation') || $errors->has('new_password'))
						<span class="help-block">{{ ($errors->has('password_confirmation')) ? $errors->first('password_confirmation') : $errors->first('new_password') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : ''  }}">
					<label class="control-label" for="password_confirmation">Type your new password again to confirm:</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password confirmation" required>
					@if ($errors->has('password_confirmation'))
						<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
					@endif
				</div>
				@csrf
				<button type="submit" class="btn btn-primary">Change password</button>
			</form>
		</div>
	</div>
</div>
