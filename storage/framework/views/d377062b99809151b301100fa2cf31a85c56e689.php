<form action="<?php echo e(url('/user/search')); ?>" method="POST" class="navbar-form navbar-left">
	

	<div class="form-group">
		<div class="input-group">
			<input type="text" class="form-control" name="keyword" placeholder="Tên người dùng cần tìm" required>
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default">tìm</button>
			</span>
		</div>
	</div>

	<?php echo csrf_field(); ?>
</form>
