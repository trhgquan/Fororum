<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			Đăng nhập
		</div>
		<div class="panel-body">
			<form action="{{ route('login') }}" method="POST" role="form">
				@if ($errors->has('content'))
					@component('templates.alert-template', ['alert_class'=>$errors->first('class'),'alert_title' => $errors->first('title'), 'alert_content'=>$errors->first('content')])
					@endcomponent
				@endif

				<div class="form-group {{ ($errors->has('username')) ? 'has-error' : '' }}">
					<label class="control-label" for="username">Tên tài khoản</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Tên tài khoản" required>
					@if ($errors->has('username'))
						<span class="help-block">{{ $errors->first('username') }}</span>
					@endif
				</div>

				<div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }} ">
					<label class="control-label" for="password">Mật khẩu</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
					@if ($errors->has('password'))
						<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>

				<div class="checkbox">
					<label>
						<input type="checkbox" id="remember_me" name="remember_me">Ghi nhớ đăng nhập
					</label>
				</div>

				@csrf

				<button type="submit" class="btn btn-primary">Đăng nhập</button>
				<hr/>
				<a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký ngay!</a>
			</form>
		</div>
	</div>
</div>
