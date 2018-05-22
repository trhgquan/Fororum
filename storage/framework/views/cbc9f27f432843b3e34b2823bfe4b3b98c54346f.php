<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			Đăng ký tài khoản
		</div>
		<div class="panel-body">
			<form action="<?php echo e(route('register')); ?>" method="POST" role="form">
				<div class="form-group <?php echo e(($errors->has('username')) ? 'has-error' : ''); ?>">
					<label class="control-label" for="username">Tên tài khoản</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Tên tài khoản" value="<?php echo e(old('username')); ?>" required>
					<?php if($errors->has('username')): ?>
						<span class="help-block"><?php echo e($errors->first('username')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group <?php echo e(($errors->has('password_confirmation') || $errors->has('password')) ? 'has-error' : ''); ?>">
					<label class="control-label" for="password">Mật khẩu</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
					<?php if($errors->has('password_confirmation') || $errors->has('password')): ?>
						<span class="help-block"><?php echo e(($errors->has('password_confirmation')) ? $errors->first('password_confirmation') : $errors->first('password')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group <?php echo e(($errors->has('password_confirmation')) ? 'has-error' : ''); ?>">
					<label class="control-label" for="password_confirmation">Nhập lại mật khẩu</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
					<?php if($errors->has('password_confirmation')): ?>
						<span class="help-block"><?php echo e($errors->first('password_confirmation')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group <?php echo e(($errors->has('email')) ? 'has-error' : ''); ?>">
					<label class="control-label" for="email">Địa chỉ email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ email" value="<?php echo e(old('email')); ?>" required>
					<?php if($errors->has('email')): ?>
						<span class="help-block"><?php echo e($errors->first('email')); ?></span>
					<?php endif; ?>
				</div>

				<div class="checkbox <?php echo e($errors->has('agrees') ? 'has-error' : ''); ?>">
					<label class="control-label" for="agrees">
						<input type="checkbox" id="agrees" name="agrees"> Tôi đồng ý với điều khoản dịch vụ và chính sách người dùng của <?php echo e(config('app.name')); ?>

					</label>
				</div>

				<?php echo csrf_field(); ?>

				<button type="submit" class="btn btn-success">Đăng ký</button>
				<hr/>
				<a href="<?php echo e(route('login')); ?>">Đã có tài khoản? Đăng nhập ngay!</a>
			</form>
		</div>
	</div>
</div>