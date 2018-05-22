<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			Chỉnh sửa mật khẩu
		</div>
		<div class="panel-body">
			<form action="<?php echo e(route('edit')); ?>" method="POST" role="form">
				<?php if($errors->has('content')): ?>
					<?php $__env->startComponent('templates.alert-template', ['alert_class'=>$errors->first('class'),'alert_title' => $errors->first('title'), 'alert_content'=>$errors->first('content')]); ?>
					<?php echo $__env->renderComponent(); ?>
				<?php endif; ?>

				<div class="form-group <?php echo e(($errors->has('password')) ? 'has-error' : ''); ?>">
					<label class="control-label" for="password">Mật khẩu hiện tại của bạn</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
					<?php if($errors->has('password')): ?>
						<span class="help-block"><?php echo e($errors->first('password')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group <?php echo e(($errors->has('password_confirmation') || $errors->has('new_password')) ? 'has-error' : ''); ?>">
					<label class="control-label" for="new_password">Mật khẩu mới</label>
					<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Mật khẩu mới" required>
					<?php if($errors->has('password_confirmation') || $errors->has('new_password')): ?>
						<span class="help-block"><?php echo e(($errors->has('password_confirmation')) ? $errors->first('password_confirmation') : $errors->first('new_password')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group <?php echo e(($errors->has('password_confirmation')) ? 'has-error' : ''); ?>">
					<label class="control-label" for="password_confirmation">Xác nhận mật khẩu</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
					<?php if($errors->has('password_confirmation')): ?>
						<span class="help-block"><?php echo e($errors->first('password_confirmation')); ?></span>
					<?php endif; ?>
				</div>
				<?php echo csrf_field(); ?>
				<button type="submit" class="btn btn-primary">Chỉnh sửa</button>
			</form>
		</div>
	</div>
</div>