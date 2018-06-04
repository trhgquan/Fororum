<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			Đăng ký tài khoản {{ config('app.name') }}
		</div>
		<div class="panel-body">
			<form action="{{ route('register') }}" method="POST" role="form">
				<div class="form-group {{ ($errors->has('username')) ? 'has-error' : '' }}">
					<label class="control-label" for="username">Tên tài khoản</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Tên tài khoản" value="{{ old('username') }}" required>
					@if ($errors->has('username'))
						<span class="help-block">{{ $errors->first('username') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password_confirmation') || $errors->has('password')) ? 'has-error' : '' }}">
					<label class="control-label" for="password">Mật khẩu</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
					@if ($errors->has('password_confirmation') || $errors->has('password'))
						<span class="help-block">{{ ($errors->has('password_confirmation')) ? $errors->first('password_confirmation') : $errors->first('password') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
					<label class="control-label" for="password_confirmation">Nhập lại mật khẩu</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
					@if ($errors->has('password_confirmation'))
						<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
					<label class="control-label" for="email">Địa chỉ email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ email" value="{{ old('email') }}" required>
					@if ($errors->has('email'))
						<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>

				<div class="checkbox {{ $errors->has('agrees') ? 'has-error' : '' }}">
					<label class="control-label" for="agrees">
						<input type="checkbox" id="agrees" name="agrees"> Tôi đồng ý với các <a href="#">điều khoản dịch vụ</a> và <a href="#">chính sách người dùng</a> của {{ config('app.name') }}
					</label>
				</div>

				@csrf

				<button type="submit" class="btn btn-success">Đăng ký</button>
				<hr/>
				<a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập ngay!</a>
			</form>
		</div>
	</div>
</div>
