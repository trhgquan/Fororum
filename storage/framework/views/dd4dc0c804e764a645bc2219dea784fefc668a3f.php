<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			Đăng nhập
		</div>
		<div class="panel-body">
			<form action="<?php echo e(route('loginRoute')); ?>" method="POST" role="form">
				<?php if($errors->has('errorName')): ?>
					<?php $__env->startComponent('layouts.alert-template', ['alert_class'=>'danger','content'=>$errors->first('errorName')]); ?>
					<?php echo $__env->renderComponent(); ?>
				<?php endif; ?>

				<div class="form-group">
					<label for="username">Tên tài khoản</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Tên tài khoản" value="<?php echo e(old('username')); ?>" required>

					<?php if($errors->has('username')): ?>
						<p style="color: red;"><?php echo e($errors->first()); ?></p>
					<?php endif; ?>
				</div>

				<div class="form-group">
					<label for="password">Mật khẩu</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>

					<?php if($errors->has('password')): ?>
						<p style="color: red;"><?php echo e($errors->first()); ?></p>
					<?php endif; ?>
				</div>			
				
				<?php echo csrf_field(); ?>
				
				<button type="submit" class="btn btn-primary">Đăng nhập</button>
				<hr/>
				<a href="<?php echo e(route('registerRoute')); ?>">Chưa có tài khoản? Đăng ký ngay!</a>
			</form>
		</div>
	</div>
</div>